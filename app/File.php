<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    //
    protected $table = 'File';
    protected $fillable = ['name','size','mime','file','extension'];
    protected $guarded = ['id'];
    
    
    public function toArray()
    {
        $array = parent::toArray();
        $array['icon'] = $this->icon;
        return $array;
    }

    public function getIconAttribute()
    {
        $var="file.png";

        if((strpos($this->mime,"image") !== false))
        {
            return "icons/image.png";
        }

        if((strpos($this->mime,"video") !== false))
        {
            return "icons/file.png";
        }

        if((strpos($this->mime,"doc") !== false))
        {
            return "icons/doc.png";
        }


        $ext=$this->extension;
        switch ($ext) 
        {
            case "rar":
                $var="compressed.png";
                break;
            case "tar":
                $var="compressed.png";
                break;
            case "zip":
                $var="compressed.png";
                break;
            case "gz":
                $var="compressed.png";
                break;
            case "mov":
                $var="video.png";
                break;
            case "app":
                $var="app.png";
                break;
            case "msi":
                $var="app.png";
                break;
            case "exe":
                $var="app.png";
                break;
            case "deb":
                $var="app.png";
                break;
            case "pkg":
                $var="app.png";
                break;
            case "pdf":
                $var="doc.png";
                break;
        }

        return "icons/".$var;
    }
}
