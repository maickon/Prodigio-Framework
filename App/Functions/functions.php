<?php

function today() {
    date_default_timezone_set('America/Sao_Paulo');
    $months = [
        'January' => 'janeiro',
        'February' => 'fevereiro',
        'March' => 'março',
        'April' => 'abril',
        'May' => 'maio',
        'June' => 'junho',
        'July' => 'julho',
        'August' => 'agosto',
        'September' => 'setembro',
        'October' => 'outubro',
        'November' => 'novembro',
        'December' => 'dezembro'
    ];
    $current = new DateTime();
    $formattedDate = $current->format('j \d\e F \d\e Y');
    $englishMonth = $current->format('F');
    $formattedDate = str_replace($englishMonth, $months[$englishMonth], $formattedDate);
    return $formattedDate;
}



function breadcrumb($title, $breadcrumb) {
    echo '
    <div class="row">
        <div class="col-12">
            <div class="page_title_box d-flex flex-wrap align-items-center justify-content-between">
                <div class="page_title_left d-flex align-items-center">
                    <h3 class="f_s_25 f_w_700 dark_text mr_30">'.$title.'</h3>
                    <ol class="breadcrumb page_bradcam mb-0">';
                    foreach ($breadcrumb as $name => $url) {
                        $active = '';
                        if(end($breadcrumb) != $url) {
                            $active = 'active';
                        }
                        echo '
                        <li class="breadcrumb-item '.$active.'"><a href="'.$url.'">'.$name.'</a></li>';
                    }
                    echo '
                    </ol>
                </div>
                <div class="page_title_right">
                    <div class="page_date_button d-flex align-items-center">
                        <img src="/assets/img/icon/calender_icon.svg" alt="">
                        '.today().'
                    </div>
                </div>
            </div>
        </div>
    </div>';
}