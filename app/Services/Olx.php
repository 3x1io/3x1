<?php


namespace App\Services;


use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;

class Olx
{
    public static function home($url)
    {
        $client = new Client(HttpClient::create(['timeout' => 60]));
        $crawler = $client->request('GET', $url);

        $urls = $crawler->filter('.ads__item__info .ads__item__ad--title')->each(function ($node) {
            return $node->attr('href');
        });
        $title = $crawler->filter('.ads__item__info .ads__item__ad--title')->each(function ($node) {
            return $node->text();
        });
        $price = $crawler->filter('.ads__item__info .ads__item__price')->each(function ($node) {
            return $node->text();
        });
//        $category = $crawler->filter('.ads__item__info .ads__item__breadcrumbs')->each(function ($node) {
//            $ex = explode(' » ', $node->text());
//            return $ex;
//        });
        $location = $crawler->filter('.ads__item__info .ads__item__info__secondary .ads__item__location')->each(function ($node) {
            return $node->text();
        });


        $data = [];
        for ($i = 0; $i < sizeof($location); $i++) {
            $crawler = $client->request('GET', $urls[$i]);

            $images = $crawler->filter('#offerdescription img')->each(function ($node) {
               return $node->attr('src');
            });
            $body = $crawler->filter('.descriptioncontent')->text();
            $phone = $crawler->filter('.contactbox-indent strong')->text();
            $author = $crawler->filter('#offeractions > div.pdingbott20 > div.user-box > div.user-box__info > p.user-box__info__name')->text();
            $category = $crawler->filter('#breadcrumbTop > tbody > tr > td.middle > ul > li')->each(function ($node){
               $url = $node->filter('a')->attr('href');
               $title =  $node->text();

               return [
                   "url" => $url,
                   "title" => $title
               ];
            });
            array_push($data, [
                "title" =>  $title[$i],
                "url" =>  $urls[$i],
                "author" => $author,
                "city" => $location[$i],
                "body" => $body,
                "images" => $images,
                "phone" => $phone,
                "tags" => $category,
                "price" => $price[$i]
            ]);
        }

        return $data;
    }

}
