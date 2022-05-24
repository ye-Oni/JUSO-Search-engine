<?php
/*
 +-------------------------------------------------------------------------+
| Copyright (C) 2022 ye5ni                             |
+-------------------------------------------------------------------------+
프로젝트  : 2022 건물 DB 프로젝트
작  성  자: 김예원
프로그램명: 건물 정보 검색 페이지
모  듈  명: function.php
작  성  일: 2022.05.23
최종수정일:
최종수정자:
수정이력:
+-------------------------------------------------------------------------+
| ye5ni@mk.co.kr                                                            |
+-------------------------------------------------------------------------+
*/

//include_once("/var/www/html/juso/cfg/config.php");
include_once("/var/www/html/juso/cfg/db.php");

// * 시도명 SELECT BOX *
function sido($ssido) {
        // 시도명 조회 쿼리문
        $query = "SELECT DISTINCT(sido) sido
                  FROM building
                  ORDER BY sido";
        $rsido = '';

        $stid = oparse($query);
        oci_execute($stid);

        // 시도 ID로 값을 불러오기
        while($row = oci_fetch_assoc($stid)){
            if ($ssido == $row['SIDO']) {
                $rsido .= "<option value=".$row['SIDO']." selected='selected'>".$row['SIDO']."</option>";
            } else {
                $rsido .= "<option value=".$row['SIDO'].">".$row['SIDO']."</option>";
            }
        } 
        
       // print($rsido);
        return $rsido;
}

echo sido('');
?>            
