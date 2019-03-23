<?php
namespace App\Helper;
use App\ArticleTag;
use App\Files;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
class mHelper
{


    static function time_ago( $zaman ){
        $zaman =  strtotime($zaman);
        $zaman_farki = time() - $zaman;
        $saniye = $zaman_farki;
        $dakika = round($zaman_farki/60);
        $saat = round($zaman_farki/3600);
        $gun = round($zaman_farki/86400);
        $hafta = round($zaman_farki/604800);
        $ay = round($zaman_farki/2419200);
        $yil = round($zaman_farki/29030400);
        if( $saniye < 60 ){
            if ($saniye == 0){
                return "az önce";
            } else {
                return $saniye .' saniye önce';
            }
        } else if ( $dakika < 60 ){
            return $dakika .' dakika önce';
        } else if ( $saat < 24 ){
            return $saat.' saat önce';
        } else if ( $gun < 7 ){
            return $gun .' gün önce';
        } else if ( $hafta < 4 ){
            return $hafta.' hafta önce';
        } else if ( $ay < 12 ){
            return $ay .' ay önce';
        } else {
            return $yil.' yıl önce';
        }
    }


    static function  rumuzcontrol($name){
        if (preg_match("/^[a-z]+[\w-]*$/i", $name)){
            return true;
        }else {
            return false;
        }
    }

    static  function permalink($string)
    {
        $find = array('Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '+', '#');
        $replace = array('c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', 'plus', 'sharp');
        $string = strtolower(str_replace($find, $replace, $string));
        $string = preg_replace("@[^A-Za-z0-9\-_\.\+]@i", ' ', $string);
        $string = trim(preg_replace('/\s+/', ' ', $string));
        $string = str_replace(' ', '-', $string);
        return $string;
    }

    static function split($text,$sayi)
    {

        if(strlen($text) > $sayi):
            $text = mb_substr($text,0,$sayi,"UTF-8")."...";
        endif;
        return strip_tags($text);
    }
}
