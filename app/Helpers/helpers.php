<?php

/**
 * dataTableRequests
 * @return result
 */
if (!function_exists('dataTableRequests')) {
    function dataTableRequests($request)
    {
        ## Read value
        $draw = $request['draw'];
        $start = $request['start'];
        $rowperpage = $request['length']; // Rows display per page

        $columnName_arr = $request['columns'];
        $search_arr = $request['search'];
        $searchValue = $search_arr['value']; // Search value


        $result = array(
            'draw' => $draw,
            'start' => $start,
            'rowperpage' => $rowperpage,
            'searchValue' => $searchValue,
            'rowperpage' => $rowperpage
        );

        return $result;
    }
}

