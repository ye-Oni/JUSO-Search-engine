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
| ye5ni                                                           |
+-------------------------------------------------------------------------+
*/

//include_once("/var/www/html/juso/cfg/config.php");
include_once("/var/www/html/juso/cfg/db.php");
//include_once("/var/www/html/juso/php/function.php");
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
                        <table style="border: 1px dashed black; border-collapse: collapse">
                            <tr>
<!--                                시도명-->
                                <td style="border:1px dashed black; padding:10px;" bgcolor="#f5f5dc">
                                <?php
                                // 시도명 조회 쿼리
                                $query = "SELECT DISTINCT(sido) sido
                                          FROM main_code
                                          ORDER BY sido";
                                $stid = oparse($query);
                                oci_execute($stid);

                                // 시도 ID 값 저장
                                if(isset($_POST['sido'])){
                                    $sido = $_POST['sido'];
                                }
                                ?>
                                <select id="sido" name="sido" width="10%" onchange="frmBuilding.submit()">
                                    <option value="-1">▽ 시도명</option>
                                    <?php
                                    // 시도 ID로 값을 불러오기
                                    while($row = oci_fetch_assoc($stid)){
                                    ?>
                                    <option value="<?php echo $row['SIDO'] ?>"
                                    <?php
                                        if($sido == $row['SIDO'])
                                            echo "selected='selected'";
                                    ?>>
                                        <?php echo $row['SIDO'] ?>
                                    </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                </td>



<!--                                시군구명-->
                                <td style="border:1px dashed black; padding:10px;" bgcolor="#f5f5dc">
                                    <?php
                                    // 시군구명 쿼리
                                    $query = "SELECT DISTINCT(gugun) gugun
                                              FROM main_code
                                              WHERE sido = '$sido'
                                              ORDER BY gugun";

                                    $stid = oparse($query);
                                    oci_execute($stid);

                                    // 시군구 ID 값 저장
                                    if(isset($_POST['gugun'])){
                                        $gugun = $_POST['gugun'];
                                    }
                                    ?>

                                    <select id="gugun" name="gugun" width="10%" onchange="frmBuilding.submit()">
                                        <option value="-1">▽ 시군구명</option>
                                        <?php
                                        while($row = oci_fetch_assoc($stid)){
                                        ?>
                                        <option value="<?php echo $row['GUGUN'] ?>"
                                        <?php
                                        if($gugun == $row['GUGUN'])
                                            echo "selected='selected'";
                                        ?>>
                                            <?php echo $row['GUGUN'] ?>
                                        </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </td>



<!--                                읍면동명-->
                            <td style="border:1px dashed black; padding:10px;">
                                <?php
                                // 읍면동명 쿼리
                                $query = "SELECT DISTINCT(dong) dong
                                          FROM main_code
                                          WHERE sido='$sido' and gugun='$gugun'
                                          ORDER BY dong";

                                $stid = oparse($query);
                                oci_execute($stid);

                                // 읍면동 ID 값 저장
                                if(isset($_POST['dong'])){
                                    $dong = $_POST['dong'];
                                }
                                ?>

                                <select id="dong" name="dong" width="10%" onchange="frmBuilding.submit()">
                                    <option value="-1">▽ 읍면동명</option>
                                    <?php
                                    while($row = oci_fetch_assoc($stid)){
                                    ?>
                                    <option value="<?php echo $row['DONG'] ?>"
                                            <?php
                                            if($dong == $row['DONG'])
                                                echo "selected='selected'";
                                            ?>>
                                        <?php echo $row['DONG'] ?>
                                    </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </td>



<!--                                도로명-->
                                <td style="border:1px dashed black; padding:10px;" bgcolor="#f5f5dc">
                                    <?php
                                    // 도로명 검색어 저장
                                    if(isset($_POST['doro'])){
                                        $doro = $_POST['doro'];
                                    }
                                    // 도로명 주소 검색 쿼리
                                    $query = "SELECT DISTINCT(sgbld) sgbld
                                          FROM building
                                          WHERE sido='$sido' and gugun='$gugun' and dong LIKE'%' and road LIKE '%$doro%'
                                          ORDER BY sgbld";

                                    $stid = oparse($query);
                                    oci_execute($stid);
                                    ?>
                                    <input type="text" name="doro" id="doro" size="20"  value="<?php echo $doro; ?>" placeholder="도로명을 입력하세요.">
                                </td>



<!--                                건물본번-->
                                <td style="border:1px dashed black; padding:10px;" bgcolor="#f5f5dc">
                                    <?php
                                    // 건물본번 검색어 저장
                                    if(isset($_POST['code'])){
                                        $code = $_POST['code'];
                                    }
                                    // 건물본번 주소 검색 쿼리
                                    $query = "SELECT DISTINCT(sgbld) sgbld
                                          FROM building
                                          WHERE sido='$sido' and gugun='$gugun' and dong LIKE'%' and road LIKE '%$doro%' and bnm LIKE '$code%'
                                          ORDER BY sgbld";

                                    $stid = oparse($query);
                                    oci_execute($stid);
                                    ?>
                                    <input type="text" name="code" id="code" size="20" value="<?php echo $code; ?>" placeholder="건물 본번을 입력하세요.">
                                </td>



<!--                                건물부번-->
                                <td style="border:1px dashed black; padding:10px;">
                                    <?php
                                    // 건물부번 검색어 저장
                                    if(isset($_POST['subCode'])){
                                        $subCode = $_POST['subCode'];
                                    }
                                    // 건물본번 주소 검색 쿼리
                                    $query = "SELECT DISTINCT(sgbld) sgbld
                                          FROM building
                                          WHERE sido='$sido' and gugun='$gugun' and dong LIKE'%' and road LIKE '%$doro%' and bnm LIKE '$code%' and bns LIKE '$subCode%'
                                          ORDER BY sgbld";

                                    $stid = oparse($query);
                                    oci_execute($stid);
                                    ?>
                                    <input type="text" name="subCode" id="subCode" size="20" value="<?php echo $subCode; ?>" placeholder="건물 부번을 입력하세요.">
                                </td>



                            <td>
                            <input type="submit" value="검 색" onchange="frmBuilding.submit()">
                                <?php
                                if($sido != null and $gugun != null and $doro != null){
                                while($row = oci_fetch_assoc($stid)){
                                ?>
                                <tr><td>
                                <?php
                                echo $row['SGBLD']
                                ?>
                                </td></tr>
                            <?php
                                }
                            }
//                                else if($sido != null and $gugun != null and $dong != null){
//                                while($row = oci_fetch_assoc($stid)){
//                                    ?>
<!--                                    <tr><td>-->
<!--                                            --><?php
//                                            echo $row['SGBLD']
//                                            ?>
<!--                                        </td></tr>-->
<!--                                    --><?php
//                                }
//                            }
                            ?>
                            </table>
                            </tr>
                        </form>
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
