<?php

namespace app\components;

class Utils {

    public static function getLevelsDirABC($base, $id, $is_url = false)
    {
        if ($is_url) {
            $DS = '/';
        } else {
            $DS = DIRECTORY_SEPARATOR;
        }

        $hash = md5($id);
        $levels = $hash[0] . $DS . $hash[1] . $DS . $hash[2];

        $dir = $base . $DS . $levels;

        if (!$is_url && !is_dir($dir)) {
            mkdir($dir, 0775, true);
        }
        return $dir;
    }

    public static function getSlug($st, $delim = '_') {

         $st = mb_strtolower($st, 'utf-8');
         $st = str_replace(array(
         '?','!','.',',',':',';','*','(',')','{','}','[',']','%','#','№','@','$','^','-','+','/','\\','=','|','"','\'',
         'а','б','в','г','д','е','ё','з','и','й','к',
         'л','м','н','о','п','р','с','т','у','ф','х',
         'ъ','ы','э',' ','ж','ц','ч','ш','щ','ь','ю','я'
         ), array(
         '_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_',
         'a','b','v','g','d','e','e','z','i','y','k',
         'l','m','n','o','p','r','s','t','u','f','h',
         'j','i','e','_','zh','ts','ch','sh','shch', '','yu','ya'
         ), $st);

        //оставим в урле только латинские буквы и цифры
        $st = preg_replace('/[^a-z0-9_]/', '', $st);
        $st = trim($st, '_');

        //удалим предлоги и прочие единичные символы
        do {
            $prev_st = $st;
            $st = preg_replace('/_[a-z0-9]_/', '_', $st);
        } while ($st != $prev_st);

        //два и более подчеркиваний заменим одним
        $st = preg_replace('/_{2,}/', '_', $st);

        if ($delim != '_') {
            $st = preg_replace('/_/', $delim, $st);
        }

        return $st;
    }
}