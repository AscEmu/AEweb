<?php

class BBCodeParser
{
    public static function toHtml($string)
    {
        $bbcodes = array(
            '~\[b\](.*?)\[/b\]~s',
            '~\[i\](.*?)\[/i\]~s',
            '~\[u\](.*?)\[/u\]~s',
            '~\[color=(.*?)\](.*?)\[/color\]~s',
            '~\[url\]((?:ftp|https?)://.*?)\[/url\]~s',
            '~\[img\](https?://.*?\.(?:jpg|jpeg|gif|png))\[/img\]~s',
            '~\[size=(.*?)\](.*?)\[/size\]~s'
        );
    
        $htmlequivalent = array(
            '<b>$1</b>',
            '<i>$1</i>',
            '<span style="text-decoration:underline;">$1</span>',
            '<span style="color:$1;">$2</span>',
            '<a href="$1">$1</a>',
            '<img src="$1" alt="" />',
            '<span style="font-size:$1px;">$2</span>'
        );
    
        return preg_replace($bbcodes, $htmlequivalent, $string);
    }
}
?>