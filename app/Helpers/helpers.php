<?php

if (! function_exists('markdown')) {
    /**
     * Compile Markdown to HTML.
     *
     * @param string|null $text
     * @return string
     */
    function markdown($text = null) {
        return app(ParsedownExtra::class)->text($text);
    }
}

if (! function_exists('gravatar_url')) {
    /**
     * Generate gravatar image url.
     *
     * @param  string  $email
     * @param  integer $size
     * @return string
     */
    function gravatar_url($email, $size = 48)
    {
        return sprintf("//www.gravatar.com/avatar/%s?s=%s", md5(strtolower(trim($email))), $size);
    }
}

if (! function_exists('gravatar_profile_url')) {
    /**
     * Generate gravatar profile page url.
     *
     * @param  string $email
     * @return string
     */
    function gravatar_profile_url($email)
    {
        return sprintf( "//www.gravatar.com/%s", md5(strtolower(trim($email))) );
    }  
}

/* 파일 경로 반환 */
if (! function_exists('attachments_path')) {
    /**
     * Generate attachments path.
     *
     * @param string $path
     * @return string
     */
    function attachments_path($path = null)
    {
        // ../public/files/$path
        return public_path('files'.($path ? DIRECTORY_SEPARATOR.$path : $path));
    }
}

/* 읽기 쉬운 파일 크기 문자열 반환 */
if (! function_exists('format_filesize')) {
    /**
     * Calculate human-readable file size string.
     *
     * @param $bytes
     * @return string
     */
    function format_filesize($bytes)
    {
        if (! is_numeric($bytes)) return 'NaN';

        $decr = 1024;
        $step = 0;
        $suffix = ['bytes', 'KB', 'MB'];

        while (($bytes / $decr) > 0.9) {
            $bytes = $bytes / $decr;
            $step ++;
        }

        return round($bytes, 2) . $suffix[$step];
    }
}


/* 정렬 조건에 맞는 페이지로 이동하는 링크 반환 */
if (! function_exists('link_for_sort')) {
    /**
     * Build HTML anchor tag for sorting
     *
     * @param string $column 정렬 필드
     * @param string $text 링크 텍스트
     * @param array  $params 링크 태그에 추가할 속성
     * @return string
     */
    function link_for_sort($column, $text, $params = [])
    {
        $direction = request()->input('sort');
        $reverse = ($direction == 'asc') ? 'desc' : 'asc';
        $activeColor = request()->input("sort") == $column ? 'text-white' : '';

        if (request()->input('sort') == $column) {
            // Update passed $text var, only if it is active sort
            $text = sprintf(
                "%s %s",
                $direction == 'asc'
                    ? '<i class="fa fa-sort-alpha-asc"></i>'
                    : '<i class="fa fa-sort-alpha-desc"></i>',
                $text
            );
        }
        
        // 인자로 받은 연관배열을 쿼리스트링으로 변환
        $queryString = http_build_query(array_merge(
            request()->except(['sort', 'order']),
            ['sort' => $column, 'order' => $reverse],
            $params
        ));

        // 반환할 링크
        return sprintf(
            '<a href="%s?%s" class="d-inline-block w-100 %s">%s</a>',
            urldecode(request()->url()),
            $queryString,
            $activeColor,
            $text,
        );
    }
}