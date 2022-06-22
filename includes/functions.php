<?php

// add function for shortcode

/*
Supported Atrributes:

- `[youtube][/youtube]` and `[yt][/yt]` are supported shortcode tag.
- `url` for youtube video URL. Example - [youtube url="https://www.youtube.com/watch?v=5Eqb_-j3FDA"][/youtube]
- `autoplay` for autoplaing video. accepting values `true` and `false`. Example - [youtube url="https://www.youtube.com/watch?v=5Eqb_-j3FDA" autoplay="true"][/youtube]
- `height` for embeded players height. Example - [youtube url="https://www.youtube.com/watch?v=5Eqb_-j3FDA" autoplay="true" height="500"][/youtube]
- `width` for embeded players width. Example - [youtube url="https://www.youtube.com/watch?v=5Eqb_-j3FDA" autoplay="true" height="500" width="650"][/youtube]
- `fullscreen` for enable and disable fullscreen. Default value true. Accepting values `true` and `false` . Example - [youtube url="https://www.youtube.com/watch?v=5Eqb_-j3FDA" autoplay="true" height="500" width="650" fullscreen="false"][/youtube]
*/

function youtube_easy_embed_callback($atts)
{


    $default = [
        'url' => '',
        'autoplay' => 'true',
        'fullscreen' => 'true',
        'height' => 500,
        'width' => 600,
    ];

    $attributes = shortcode_atts($default, $atts);

    if (isset($attributes['url'])) {
        $url = $attributes['url'];


        // checking for direct video url

        if (substr_count($url, 'v=') > 0) {

            // if url is direct youtube video then extract the youtube video id
            $explodeUrl = explode('v=', $url);

            // check for other video parameters and extract only video id
            if (substr_count($explodeUrl[1], '&') > 0) {

                // set video id for embed url
                $expParms = explode('&', $explodeUrl[1]);
                $videoId = $expParms[0];
                $url = 'https://www.youtube.com/embed/' . $videoId;
            } else {

                // if there is no additional parameter
                $url = 'https://www.youtube.com/embed/' . $explodeUrl[1];
            }
        }



        // autoplay video - true / false

        if (isset($attributes['autoplay']) && $attributes['autoplay'] == "true") {
            $url .= '?autoplay=1';
        }

        // control full screen from user end // default value true or false;

        if (isset($attributes['fullscreen'])) {

            if ($attributes['fullscreen'] == 'true') {

                $fullscreen = 'allowfullscreen';
            } else {
                $fullscreen = '';
            }
        } else {
            $fullscreen = 'allowfullscreen';
        }

        // custom height form user end
        if (isset($attributes['height']) && $attributes['height'] > 0) {
            $height = $attributes['height'];
        } else {
            $height = 315;
        }

        // custom width from user end

        if (isset($attributes['width']) && $attributes['width'] > 0) {
            $width = $attributes['width'];
        } else {
            $width = 420;
        }

        // adding time for no embed url cache
        // if (substr_count($url, '?') > 0) {
        //     $url .= '&amp;playtime=' . time();
        // } else {
        //     $url .= '?playtime=' . time();
        // }


        return sprintf('<iframe src="%s" height="%s" width="%s" frameborder="0" %s></iframe>', $url, $height, $width, $fullscreen);
    } else {
        // returning false if their is no video url
        return false;
    }
}

// adding shortcode for [youtube][/youtube]
add_shortcode('youtube', 'youtube_easy_embed_callback');

// adding shorrtcode for [yt][/yt]
add_shortcode('yt', 'youtube_easy_embed_callback');
