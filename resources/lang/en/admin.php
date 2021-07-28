<?php

return [
    'admin-user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
            'edit_profile' => 'Edit Profile',
            'edit_password' => 'Edit Password',
        ],

        'columns' => [
            'id' => 'ID',
            'last_login_at' => 'Last login',
            'activated' => 'Activated',
            'email' => 'Email',
            'first_name' => 'First name',
            'forbidden' => 'Forbidden',
            'language' => 'Language',
            'last_name' => 'Last name',
            'password' => 'Password',
            'password_repeat' => 'Password Confirmation',
                
            //Belongs to many relations
            'roles' => 'Roles',
                
        ],
    ],

    'setting' => [
        'title' => 'Settings',

        'actions' => [
            'index' => 'Settings',
            'create' => 'New Setting',
            'edit' => 'Edit :name',
            'export' => 'Export',
        ],

        'columns' => [
            'id' => 'ID',
            'group' => 'Group',
            'key' => 'Key',
            'value' => 'Value',
            
        ],
    ],

    'role' => [
        'title' => 'Roles',

        'actions' => [
            'index' => 'Roles',
            'create' => 'New Role',
            'edit' => 'Edit :name',
            'export' => 'Export',
        ],

        'columns' => [
            'id' => 'ID',
            'guard_name' => 'Guard name',
            'name' => 'Name',
            
        ],
    ],

    'permission' => [
        'title' => 'Permissions',

        'actions' => [
            'index' => 'Permissions',
            'create' => 'New Permission',
            'edit' => 'Edit :name',
            'export' => 'Export',
        ],

        'columns' => [
            'id' => 'ID',
            'guard_name' => 'Guard name',
            'name' => 'Name',
            
        ],
    ],

    'user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
            'export' => 'Export',
        ],

        'columns' => [
            'id' => 'ID',
            'api_key' => 'Api key',
            'apps' => 'Apps',
            'email' => 'Email',
            'email_verified_at' => 'Email verified at',
            'first_name' => 'First name',
            'global_id' => 'Global',
            'info' => 'Info',
            'last_name' => 'Last name',
            'name' => 'Name',
            'password' => 'Password',
            'phone' => 'Phone',
            'store' => 'Store',
            'tenant_id' => 'Tenant',
            'type' => 'Type',
            'username' => 'Username',
            'activated' => "Activated",
            'blocked' => "Blocked"
            
        ],
    ],

    'domain' => [
        'title' => 'Domains',

        'actions' => [
            'index' => 'Domains',
            'create' => 'New Domain',
            'edit' => 'Edit :name',
            'export' => 'Export',
        ],

        'columns' => [
            'id' => 'ID',
            'domain' => 'Domain',
            'tenant_id' => 'Tenant',
            
        ],
    ],

    'medium' => [
        'title' => 'Media',

        'actions' => [
            'index' => 'Media',
            'create' => 'New Media',
            'edit' => 'Edit :name',
            'export' => 'Export',
        ],

        'columns' => [
            'id' => 'ID',
            'collection_name' => 'Collection name',
            'conversions_disk' => 'Conversions disk',
            'custom_properties' => 'Custom properties',
            'disk' => 'Disk',
            'file_name' => 'File name',
            'generated_conversions' => 'Generated conversions',
            'manipulations' => 'Manipulations',
            'mime_type' => 'Mime type',
            'model_id' => 'Model',
            'model_type' => 'Model type',
            'name' => 'Name',
            'order_column' => 'Order column',
            'responsive_images' => 'Responsive images',
            'size' => 'Size',
            'uuid' => 'Uuid',
            
        ],
    ],

    'user-notification' => [
        'title' => 'User Notifications',

        'actions' => [
            'index' => 'User Notifications',
            'create' => 'New User Notification',
            'edit' => 'Edit :name',
            'export' => 'Export',
        ],

        'columns' => [
            'id' => 'ID',
            'sender_id' => 'Sender',
            'title' => 'Title',
            'message' => 'Message',
            'icon' => 'Icon',
            'url' => 'Url',
            'type' => 'Type',
            'user_id' => 'User',
            
        ],
    ],

    'email' => [
        'title' => 'Emails',

        'actions' => [
            'index' => 'Emails',
            'create' => 'New Email',
            'edit' => 'Edit :name',
            'export' => 'Export',
        ],

        'columns' => [
            'id' => 'ID',
            'to_email' => 'To email',
            'from_email' => 'From email',
            'subject' => 'Subject',
            'message' => 'Message',
            'type' => 'Type',
            'group_id' => 'Group',
            
        ],
    ],

    'country' => [
        'title' => 'Countries',

        'actions' => [
            'index' => 'Countries',
            'create' => 'New Country',
            'edit' => 'Edit :name',
            'export' => 'Export',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Code',
            'phone' => 'Phone',
            'lat' => 'Lat',
            'lang' => 'Lang',
            
        ],
    ],

    'city' => [
        'title' => 'Cities',

        'actions' => [
            'index' => 'Cities',
            'create' => 'New City',
            'edit' => 'Edit :name',
            'export' => 'Export',
        ],

        'columns' => [
            'id' => 'ID',
            'country_id' => 'Country',
            'lang' => 'Lang',
            'lat' => 'Lat',
            'name' => 'Name',
            'price' => 'Price',
            'shipping' => 'Shipping',
            
        ],
    ],

    'area' => [
        'title' => 'Areas',

        'actions' => [
            'index' => 'Areas',
            'create' => 'New Area',
            'edit' => 'Edit :name',
            'export' => 'Export',
        ],

        'columns' => [
            'id' => 'ID',
            'city_id' => 'City',
            'lang' => 'Lang',
            'lat' => 'Lat',
            'name' => 'Name',
            
        ],
    ],

    'currency' => [
        'title' => 'Currencies',

        'actions' => [
            'index' => 'Currencies',
            'create' => 'New Currency',
            'edit' => 'Edit :name',
            'export' => 'Export',
        ],

        'columns' => [
            'id' => 'ID',
            'arabic' => 'Arabic',
            'iso' => 'Iso',
            'name' => 'Name',
            
        ],
    ],

    'branch' => [
        'title' => 'Branches',

        'actions' => [
            'index' => 'Branches',
            'create' => 'New Branch',
            'edit' => 'Edit :name',
            'export' => 'Export',
        ],

        'columns' => [
            'id' => 'ID',
            'address' => 'Address',
            'in' => 'In',
            'name' => 'Name',
            'out' => 'Out',
            'phone' => 'Phone',
            
        ],
    ],

    'language' => [
        'title' => 'Languages',

        'actions' => [
            'index' => 'Languages',
            'create' => 'New Language',
            'edit' => 'Edit :name',
            'export' => 'Export',
        ],

        'columns' => [
            'id' => 'ID',
            'arabic' => 'Arabic',
            'iso' => 'Iso',
            'name' => 'Name',
            
        ],
    ],

    'category' => [
        'title' => 'Categories',

        'actions' => [
            'index' => 'Categories',
            'create' => 'New Category',
            'edit' => 'Edit :name',
            'export' => 'Export',
        ],

        'columns' => [
            'id' => 'ID',
            'activated' => 'Activated',
            'description' => 'Description',
            'menu' => 'Menu',
            'name' => 'Name',
            'parent_id' => 'Parent',
            'seo_id' => 'Seo',
            'slug' => 'Slug',
            'sub' => 'Sub',
            
        ],
    ],

    'tag' => [
        'title' => 'Tags',

        'actions' => [
            'index' => 'Tags',
            'create' => 'New Tag',
            'edit' => 'Edit :name',
            'export' => 'Export',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            'seo_id' => 'Seo',
            'slug' => 'Slug',
            
        ],
    ],

    'seo' => [
        'title' => 'Seos',

        'actions' => [
            'index' => 'Seos',
            'create' => 'New Seo',
            'edit' => 'Edit :name',
            'export' => 'Export',
        ],

        'columns' => [
            'id' => 'ID',
            'buy' => 'Buy',
            'description' => 'Description',
            'keywords' => 'Keywords',
            'like' => 'Like',
            'search' => 'Search',
            'share' => 'Share',
            'title' => 'Title',
            'view' => 'View',
            
        ],
    ],

    'section' => [
        'title' => 'Sections',

        'actions' => [
            'index' => 'Sections',
            'create' => 'New Section',
            'edit' => 'Edit :name',
            'export' => 'Export',
        ],

        'columns' => [
            'id' => 'ID',
            
        ],
    ],

    'section' => [
        'title' => 'Sections',

        'actions' => [
            'index' => 'Sections',
            'create' => 'New Section',
            'edit' => 'Edit :name',
            'export' => 'Export',
        ],

        'columns' => [
            'id' => 'ID',
            'button' => 'Button',
            'description' => 'Description',
            'html' => 'Html',
            'order' => 'Order',
            'subtitle' => 'Subtitle',
            'table' => 'Table',
            'title' => 'Title',
            'type' => 'Type',
            'url' => 'Url',
            
        ],
    ],

    'feature' => [
        'title' => 'Features',

        'actions' => [
            'index' => 'Features',
            'create' => 'New Feature',
            'edit' => 'Edit :name',
            'export' => 'Export',
        ],

        'columns' => [
            'id' => 'ID',
            'button' => 'Button',
            'description' => 'Description',
            'icon' => 'Icon',
            'order' => 'Order',
            'place' => 'Place',
            'title' => 'Title',
            'url' => 'Url',
            
        ],
    ],

    'search' => [
        'title' => 'Searches',

        'actions' => [
            'index' => 'Searches',
            'create' => 'New Search',
            'edit' => 'Edit :name',
            'export' => 'Export',
        ],

        'columns' => [
            'id' => 'ID',
            'counter' => 'Counter',
            'last_searched' => 'Last searched',
            'search' => 'Search',
            
        ],
    ],

    'ad' => [
        'title' => 'Ads',

        'actions' => [
            'index' => 'Ads',
            'create' => 'New Ad',
            'edit' => 'Edit :name',
            'export' => 'Export',
        ],

        'columns' => [
            'id' => 'ID',
            'activated' => 'Activated',
            'button' => 'Button',
            'clicked' => 'Clicked',
            'description' => 'Description',
            'subtitle' => 'Subtitle',
            'title' => 'Title',
            'type' => 'Type',
            'url' => 'Url',
            
        ],
    ],

    'cart' => [
        'title' => 'Carts',

        'actions' => [
            'index' => 'Carts',
            'create' => 'New Cart',
            'edit' => 'Edit :name',
            'export' => 'Export',
        ],

        'columns' => [
            'id' => 'ID',
            'customer_id' => 'Customer',
            'discount' => 'Discount',
            'fee' => 'Fee',
            'item' => 'Item',
            'item_id' => 'Item',
            'item_type' => 'Item type',
            'price' => 'Price',
            'promo' => 'Promo',
            'promo_id' => 'Promo',
            'qnt' => 'Qnt',
            'ref_id' => 'Ref',
            'ref_type' => 'Ref type',
            'return' => 'Return',
            'total' => 'Total',
            'uuid' => 'Uuid',
            
        ],
    ],

    'wishlist' => [
        'title' => 'Wishlists',

        'actions' => [
            'index' => 'Wishlists',
            'create' => 'New Wishlist',
            'edit' => 'Edit :name',
            'export' => 'Export',
        ],

        'columns' => [
            'id' => 'ID',
            'customer_id' => 'Customer',
            'type' => 'Type',
            'type_id' => 'Type',
            
        ],
    ],

    'block' => [
        'title' => 'Blocks',

        'actions' => [
            'index' => 'Blocks',
            'create' => 'New Block',
            'edit' => 'Edit :name',
            'export' => 'Export',
        ],

        'columns' => [
            'id' => 'ID',
            'key' => 'Key',
            'html' => 'Html',
            
        ],
    ],

    // Do not delete me :) I'm used for auto-generation
];
