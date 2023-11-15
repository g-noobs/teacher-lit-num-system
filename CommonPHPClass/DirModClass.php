<?php 

class DirModClass{

    function modSubDirecPath($extension){
        switch ($extension) {
            case 'mp4':
            case 'avi':
            case 'mov':
                return 'Videos';
            case 'mp3':
            case 'wav':
            case 'ogg':
                return 'Audios';
            case 'jpg':
            case 'jpeg':
            case 'png':
                return 'Images';
            case 'pdf':
            case 'doc':
            case 'docx':
                return 'Documents';
            default:
                return 'Others';
    }
}   

}

?>