<?php
/*
 +-------------------------------------------------------------------------+
| Copyright (C) 2022 ye5ni                             |
+-------------------------------------------------------------------------+
프로젝트  : 2022 건물 DB 프로젝트
작  성  자: 김예원
프로그램명: 건물 정보 검색 페이지
모  듈  명: building.php
작  성  일: 2022.05.23
최종수정일:
최종수정자:
수정이력:
+-------------------------------------------------------------------------+
| ye5ni@mk.co.kr                                                            |
+-------------------------------------------------------------------------+
*/

//include_once("/var/www/html/juso/cfg/config.php");
//include_once("/var/www/html/juso/cfg/db.php");
include_once("/var/www/html/juso/php/function.php");
?>

<html>
    <head>
        <title> 건물 정보 검색하기</title>
    </head>
    <body>
        <br>
        <table width="750">
            <tr>
                <th><h2>주소 정보를 활용한 건물 검색 사이트</h2></th>
            </tr>
        </table>
        <table>
            <form id="frmBuilding" name="frmBuilding" action="building.php" method="POST">
                <tr>
                    <td>
                        <hr><br>
                        <table style="border: 1px dashed black; border-collapse: collapse;">
                            <tr>
                                <?php
                                    $sido = sido();
                                    echo $sido;
                                    $gugun = gugun($sido);

                                    $dong = dong($sido, $gugun);


                                ?>
                                <td>
                                    <input type="submit" value="검 색"">
                                </td>
                            </tr>
                        </table>
                        <br/>
                        <br/>
                        <br/>
                        <table>
                            <a href="/juso/index.html" alt='메인'>메인으로 이동</a>
                        </table>
                    </td>
                </tr>
            </form>
        </table>
    </body>
</html>
