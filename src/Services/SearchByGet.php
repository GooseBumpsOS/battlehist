<?php
/**
 * Created by PhpStorm.
 * User: georgy
 * Date: 02.01.19
 * Time: 17:29
 */

namespace App\Services;

use App\Entity\Post;


class SearchByGet
{
    public function searchByGet($em){

        if(!empty($_GET))
        {
            return $searchPost = $em->search($_GET['query']); //передаем в поиск гет запрос
        }

    }

    public function searchByURL($em, $url){

        $search_str = $this->strToURL($url);


        return $searchPost = $em->searchTag($search_str);

    }

    public function strToURL($search_str){

        switch ($search_str){

            case 'vietnam':
                $search_str = 'Вьетнам';
                break;

            case 'chechnya':
                $search_str = 'Чечня';
                break;
//
//            case 'arab–israeli':
//                $search_str = 'Арабо-Израильский конфликт';
//                break;
//
//            case 'iraq':
//                $search_str = 'Ирак';
//                break;

            case 'Вьетнам':
                $search_str = 'vietnam';
                break;

            case 'Чечня':
                $search_str = 'chechnya';
                break;

//            case 'Арабо-Израильский конфликт':
//                $search_str = 'arab–israeli';
//                break;
//
//            case 'Ирак':
//                $search_str = 'iraq';
//                break;

            case 'Первая Мировая война':
                $search_str = 'pmv';
                break;

            case 'pmv':
                $search_str = 'Первая Мировая война';
                break;

            default:
                $search_str = ' ';
                break;
        }

        return $search_str;

    }
}