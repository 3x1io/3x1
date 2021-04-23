<?php


namespace App\Services;

use Symfony\Component\DomCrawler\Crawler;

class Haraj
{
    private static $base = 'https://haraj.com.sa';

    public static function convert($url){
        $get = file_get_contents($url);
        $beautify = new HTML(array(
            'indent_inner_html' => false,
            'indent_char' => " ",
            'indent_size' => 1,
            'wrap_line_length' => 32786,
            'unformatted' => ['code', 'pre'],
            'preserve_newlines' => false,
            'max_preserve_newlines' => 32786,
            'indent_scripts'	=> 'normal' // keep|separate|normal
        ));
        $clean = $beautify->beautify($get);

        return new Crawler($clean);
    }

    public static function home($url){
        $crawler = self::convert($url);
        $titles = $crawler->filter('.post .postInfo .postTitle')->each(function ($node){
            return $node->text();
        });
        $base = self::$base;

        $url = $crawler->filter('.post .postInfo .postTitle a')->each(function ($node) use ($base){
            return $base . $node->attr('href');
        });

        $data = [];
        for($i=0; $i<sizeof($titles); $i++){
            $crawler = self::convert($url[$i]);

            $author = $crawler->filter('#root > div > div.postWrapper > div.postMain > div.details > div.post_header > div > div > div:nth-child(1) > span:nth-child(1)')->text();
            $city = $crawler->filter('#root > div > div.postWrapper > div.postMain > div.details > div.post_header > div > div > div:nth-child(2) > span > a > span')->text();
            $body = $crawler->filter('#root > div > div.postWrapper > div.postMain > div.details > div.post_body > article')->text();
            $phone = $crawler->filter('#root > div > div.postWrapper > div.postMain > div.details > div.post_body > div > span')->text();
            $images = $crawler->filter('#root > div > div.postWrapper > div.postMain > div.details > div.post_body > .img_wrapper img')->each(function ($node) {
                $image = [];
                $exploadCut = explode(',', $node->attr('srcset'));
                foreach($exploadCut as $getImage){
                    $getImage = str_replace(' 400w', '', $getImage);
                    $getImage = str_replace(' 700w', '', $getImage);
                    $getImage = str_replace(' ', '', $getImage);
                    array_push($image, $getImage);
                }

                return $image;
            });
            $tags = $crawler->filter('#root > div > div.postWrapper > div.postMain > div.tags_wrapper a')->each(function ($node) {
                return $node->text();
            });

            array_push($data, [
                "title" =>  $titles[$i],
                "url" =>  $url[$i],
                "author" => $author,
                "city" => $city,
                "body" => $body,
                "images" => $images,
                "phone" => $phone,
                "tags" => $tags
            ]);
        }

        return $data;
    }
}
