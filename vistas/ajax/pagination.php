<?php
function paginate($reload, $page, $tpages, $adjacents)
{
    $prevlabel = "&lsaquo; Anterior";
    $nextlabel = "Siguiente &rsaquo;";
    $out       = '<ul class="pagination justify-content-center">';

    // previous label

    if ($page == 1) {
        $out .= "<li class='page-item disabled'><a class='page-link' href='#' tabindex='-1'>$prevlabel</a></li>";
    } else if ($page == 2) {
        $out .= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='load(1)'>$prevlabel</a></li>";
    } else {
        $out .= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='load(" . ($page - 1) . ")'>$prevlabel</a></li>";

    }

    // first label
    if ($page > ($adjacents + 1)) {
        $out .= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='load(1)'>1</a></li>";
    }
    // interval
    if ($page > ($adjacents + 2)) {
        $out .= "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
    }

    // pages

    $pmin = ($page > $adjacents) ? ($page - $adjacents) : 1;
    $pmax = ($page < ($tpages - $adjacents)) ? ($page + $adjacents) : $tpages;
    for ($i = $pmin; $i <= $pmax; $i++) {
        if ($i == $page) {
            $out .= "<li class='page-item active'><a class='page-link' href='#' tabindex='-1'>$i</a></li>";
        } else if ($i == 1) {
            $out .= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='load(1)'>$i</a></li>";
        } else {
            $out .= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='load(" . $i . ")'>$i</a></li>";
        }
    }

    // interval

    if ($page < ($tpages - $adjacents - 1)) {
        $out .= "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
    }

    // last

    if ($page < ($tpages - $adjacents)) {
        $out .= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='load(1)'>$tpages</a></li>";
    }

    // next

    if ($page < $tpages) {
        $out .= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='load(" . ($page + 1) . ")'>$nextlabel</a></li>";
    } else {
        $out .= "<li class='page-item disabled'><a class='page-link' href='#'>$nextlabel</a></li>";
    }

    $out .= "</ul>";
    return $out;
}
