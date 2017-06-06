<?
class Shingles {
    
    const SHINGLES_LEN = 2 ;
    
    public static function analyze ($source1, $source2)
    {
        $words1 = self::canonize($source1) ;
        $shingles1 = self::shinglesGen($words1) ;
        
        $words2 = self::canonize($source2) ;
        $shingles2 = self::shinglesGen($words2) ;        
        
        $intersection = array_intersect($shingles1, $shingles2) ;
        
        $intersectionPercent = (count($intersection) / count($words1)) * 100 ;
        
        return $intersectionPercent ;
    }
    

     public static function analyze2 ($source1, $source2, $source1_words_count)
    {
        $intersection = array_intersect($source1, $source2) ;
        
        
        $intersectionPercent = (count($intersection) / $source1_words_count) * 100 ;
        
        return $intersectionPercent ;
    }


     public static function analyze3 ($source1, $source2, $source1_words_count)
    {
        $intersection = array_intersect($source1, $source2) ;
        
        
        $intersectionPercent = (count($intersection) / $source1_words_count) * 100 ;
        
        return $intersectionPercent ;
    }
    
    public static function canonize($text)
    {
        $words = explode(' ', $text) ;
        
        $result = array() ;
        foreach($words as $k=>$w)
        {
            $w = mb_strtolower($w) ;
            $w = preg_replace(self::$filter, '', $w) ;
            
            if(!empty($w)) {
                $result[] = trim($w); ;
            }
        }   
        
        return $result ;
    }
    
    
    public static function shinglesGen($words)
    {
        $wordsLen = count($words) ;
        $shinglesCount = $wordsLen - (self::SHINGLES_LEN - 1) ;
        
        $shingles = array() ;
    
        
        for($i=0; $i < $shinglesCount; $i++)
        {
            $sh = array() ;
            for($k=$i; $k < $i + self::SHINGLES_LEN; $k++)
            {                                
                $sh[] = $words[$k] ;
            }
            
            $shingles[] = crc32( implode(' ', $sh) ) ;
        }
        
        return $shingles ;
    }
    
    
    private static $filter = array(
        '/,/', 
        '/\./', 
        '/\!/', 
        '/\?/', 
        '/\(/', 
        '/\)/', 
        '/-/', 
        '/—/', 
        '/:/', 
        '/;/',
        '/"/',
          
        '/^это$/', 
        '/^как$/', 
        '/^так$/', 
        '/^в$/', 
        '/^на$/', 
        '/^над$/', 
        '/^к$/', 
        '/^ко$/', 
        '/^до$/', 
        '/^за$/', 
        '/^то$/', 
        '/^с$/', 
        '/^со$/', 
        '/^для$/', 
        '/^о$/', 
        '/^ну$/', 
        '/^же$/', 
        '/^ж$/', 
        '/^что$/', 
        '/^он$/', 
        '/^она$/', 
        '/^б$/', 
        '/^бы$/', 
        '/^ли$/',
        '/^и$/',
        '/^у$/'
    ) ;    
    
}

?>