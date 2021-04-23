<?php

namespace Brackets\AdminAuth\Activation\Repositories;

use Brackets\AdminAuth\Activation\Contracts\CanActivate as CanActivateContract;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Str;

class DatabaseTokenRepository implements TokenRepositoryInterface
{
    /**
     * The database connection instance.
     *
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * The Hasher implementation.
     *
     * @var HasherContract
     */
    protected $hasher;

    /**
     * The token database table.
     *
     * @var string
     */
    protected $table;

    /**
     * The hashing key.
     *
     * @var string
     */
    protected $hashKey;

    /**
     * The number of seconds a token should last.
     *
     * @var int
     */
    protected $expires;

    /**
     * Create a new token repository instance.
     *
     * @param ConnectionInterface $connection
     * @param HasherContract $hasher
     * @param string $table
     * @param string $hashKey
     * @param int $expires
     * @return void
     */
    public function __construct(
        ConnectionInterface $connection,
        HasherContract $hasher,
        $table,
        $hashKey,
        $expires = 60
    ) {
        $this->table = $table;
        $this->hasher = $hasher;
        $this->hashKey = $hashKey;
        $this->expires = $expires * 60;
        $this->connection = $connection;
    }

    /**
     * Get a token record by user if exists and is valid.
     *
     * @param CanActivateContract $user
     * @return array|null
     */
    public function getByUser(CanActivateContract $user): ?array
    {
        return (array)$this->getTable()
            ->where(['email' => $user->getEmailForActivation(), 'used' => false])
            ->where('created_at', '>=', Carbon::now()->subSeconds($this->expires))
            ->first();
    }

    /**
     * Get a token record by token if exists and is valid.
     *
     * @param string $token
     * @return array|null
     */
    public function getByToken($token): ?array
    {
        return (array)$this->getTable()
            ->where(['token' => $token, 'used' => false])
            ->where('created_at', '>=', Carbon::now()->subSeconds($this->expires))
            ->first();
    }

    /**
     * Create a new token record.
     *
     * @param CanActivateContract $user
     * @throws Exception
     * @return string
     */
    public function create(CanActivateContract $user): string
    {
        $email = $user->getEmailForActivation();

        // We will create a new, random token for the user so that we can e-mail them
        // a safe link to activate. Then we will insert a record in
        // the database so that we can verify the token within the actual activation.
        $token = $this->createNewToken();

        $this->getTable()->insert($this->getPayload($email, $token));

        return $token;
    }

    /**
     * Create a new token or get existing not expired and not used.
     *
     * @param CanActivateContract $user
     * @throws Exception
     * @return string
     */
    public function createOrGet(CanActivateContract $user): string
    {
        $email = $user->getEmailForActivation();

        if (!empty($record = $this->getByUser($user))) {
            $token = $record['token'];
        } else {
            // We will create a new, random token for the user so that we can e-mail them
            // a safe link to activate. Then we will insert a record in
            // the database so that we can verify the token within the actual activation.
            $token = $this->createNewToken();

            $this->getTable()->insert($this->getPayload($email, $token));
        }

        return $token;
    }

    /**
     * Mark all token records as used by user.
     *
     * @param CanActivateContract $user
     * @param string|null $token
     * @return void
     */
    public function markAsUsed(CanActivateContract $user, $token = null): void
    {
        $query = $this->getTable()
            ->where('email', $user->getEmailForActivation());
        if ($token !== null) {
            $query = $query->where('token', $token);
        }
        $query->update(['used' => true]);
    }

    /**
     * Delete all existing activation tokens from the database.
     *
     * @param CanActivateContract $user
     * @return int
     */
    protected function deleteExisting(CanActivateContract $user): ?int
    {
        return $this->getTable()->where('email', $user->getEmailForPasswordReset())->delete();
    }

    /**
     * Build the record payload for the table.
     *
     * @param string $email
     * @param string $token
     * @throws Exception
     * @return array
     */
    protected function getPayload($email, $token): array
    {
        return ['email' => $email, 'token' => $token, 'created_at' => new Carbon];
    }

    /**
     * Determine if a token record exists and is valid.
     *
     * @param CanActivateContract $user
     * @param string $token
     * @return bool
     */
    public function exists(CanActivateContract $user, $token): bool
    {
        $record = (array)$this->getTable()->where(
            ['email' => $user->getEmailForActivation(), 'used' => false]
        )->first();

        return $record &&
            !$this->tokenExpired($record['created_at']) &&
            $token === $record['token'];
    }

    /**
     * Determine if the token has expired.
     *
     * @param string $createdAt
     * @return bool
     */
    protected function tokenExpired($createdAt): bool
    {
        return Carbon::parse($createdAt)->addSeconds($this->expires)->isPast();
    }

    /**
     * Delete a token record by user.
     *
     * @param CanActivateContract $user
     * @return void
     */
    public function delete(CanActivateContract $user): void
    {
        $this->deleteExisting($user);
    }

    /**
     * Delete expired tokens.
     *
     * @return void
     */
    public function deleteExpired(): void
    {
        $expiredAt = Carbon::now()->subSeconds($this->expires);

        $this->getTable()->where('created_at', '<', $expiredAt)->delete();
    }

    /**
     * Create a new token for the user.
     *
     * @return string
     */
    public function createNewToken(): string
    {
        return hash_hmac('sha256', Str::random(40), $this->hashKey);
    }

    /**
     * Get the database connection instance.
     *
     * @return ConnectionInterface
     */
    public function getConnection(): ConnectionInterface
    {
        return $this->connection;
    }

    /**
     * Begin a new database query against the table.
     *
     * @return Builder
     */
    protected function getTable(): Builder
    {
        return $this->connection->table($this->table);
    }

    /**
     * Get the hasher instance.
     *
     * @return HasherContract
     */
    public function getHasher(): HasherContract
    {
        return $this->hasher;
    }
}
