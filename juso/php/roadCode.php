<?php
/*
 +-------------------------------------------------------------------------+
| Copyright (C) 2022 ye5ni                             |
+-------------------------------------------------------------------------+
프로젝트  : 2022 건물 DB 프로젝트
작  성  자: 김예원
프로그램명: 도로명 주소 검색 페이지
모  듈  명: roadCode.php
작  성  일: 2022.05.11
최종수정일: 2022.05.20
최종수정자:
수정이력:
+-------------------------------------------------------------------------+
| ye5ni@mk.co.kr                                                            |
+-------------------------------------------------------------------------+
*/

//include_once("/var/www/html/juso/cfg/config.php");
include_once("/var/www/html/juso/cfg/db.php");
?>
<html>
    <head>
        <title>도로명 주소 검색하기</title>
    </head>
    <body>
    <br/>
        <table width="750">
            <tr>
                <th><h2>도로명 주소 검색하기</h2>
                </th>
            </tr>
        </table>
        <table width="750">
            <form id="frmRoadCode" name="frmRoadCode" action="roadCode.php" method="POST">
        <tr>
            <td>
                <hr><br>
                    <table style="border: 1px dashed black; border-collapse: collapse;">
                    <td style="border:1px dashed black; padding:10px;">
<!--                        * SIDO *-->
                        <?php
                        // 시도명 쿼리
                        $query = "SELECT DISTINCT(sido) AS sido, SUBSTR(scd, 1, 2) AS sdid 
                                FROM road_code
                                ORDER BY sdid, sido";
                        $stid = oparse($query);
                        oci_execute($stid) ;

                        // 시도 ID 값 저장
                        if(isset($_POST['sidoID'])){
                            $sdid = $_POST['sidoID'];
                        }
                        ?>

                    <select id="sidoID" name="sidoID" width="10%" onchange="frmRoadCode.submit()">

                        <option value="-1">시도명</option>

                        // 시도 ID로 값을 불러오기
                        <?php
                        while($row = oci_fetch_assoc($stid)){
                        ?>
                        <option value="<?php echo $row['SDID'] ?>"
                        <?php
                            if($sdid == $row['SDID']) echo "selected='selected'";
                        ?>>
                            <?php echo $row['SIDO'] ?>
                        </option>
                        <?php
                        }
                        ?>
                    </select>
                    </td>

<!--                        * SIGUNGU *-->
                    <td style="border:1px dashed black; padding:10px;">
                        <?php
                        // 시군구명 쿼리
                        $query = "SELECT DISTINCT(gugun) as gugun, scd
                        FROM road_code
                        WHERE scd LIKE '$sdid%'
                        ORDER BY gugun";

                        $stid = oparse($query);
                        oci_execute($stid) ;

                        // 시군구 ID 값 저장
                        if(isset($_POST['gugunID'])){
                            $sgid = $_POST['gugunID'];
                        }
                        ?>

                    <select id="gugunID" name="gugunID" width="10%" onchange="frmRoadCode.submit()">
                        <option value="-1">시군구명</option>
                        // 시군구명 select Box 출력
                        <?php
                        while($row = oci_fetch_assoc($stid)){
                        ?>
                        <option value="<?php echo $row['SCD'] ?>"
                        <?php
                        if($sgid == $row['SCD']) echo "selected='selected'";
                        ?>>
                            <?php echo $row['GUGUN'] ?>
                        </option>
                        <?php
                        }
                        ?>
                    </select>
                    </td>

<!--                        * DONG *-->
                    <td style="border:1px dashed black; padding:10px;">
                        <?php
                        // 읍면동명 쿼리(존재할 때)
                        $query = "SELECT DISTINCT(dong) as dong, dongcd, scd
                        FROM road_code
                        WHERE scd='$sgid' AND dong IS NOT NULL
                        ORDER BY dong";

                        $stid = oparse($query);
                        oci_execute($stid) ;

                        // 읍면동 ID 값 저장
                        if(isset($_POST['dongID'])){
                            $did = $_POST['dongID'];
                        }
                        ?>

                    <select id="dongID" name="dongID" width="10%" onchange="frmRoadCode.submit()">
                        <option value="-1">읍면동명</option>
                        // 읍면동명 select Box 출력
                       <?php
                        while($row = oci_fetch_assoc($stid)){
                            ?>
                            <option value="<?php echo $row['DONGCD'] ?>"
                                <?php
                                if($did == $row['DONGCD']) echo "selected='selected'";
                                ?>>
                                <?php echo $row['DONG'] ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                    </td>

<!--                        * DORO *-->
                    <td style="border:1px dashed black; padding:10px;">
                        <input type="text" name="doroID" id="doroID" size="20">
                    </td>

                    <td>
<!--                        // 도로명 주소 검색-->
                        <?php
                        // 도로명 ID 값 저장
                        if(isset($_POST['doroID'])){
                            $doro = $_POST['doroID'];
                        }

                        // 읍면동명에 값을 넣었을 때의 쿼리(검색 박스에는 입력된 상태-도로명)
                        if($did != -1) {
                            $query = "SELECT road, rno
                            FROM road_code
                            WHERE scd='$sgid' AND dongcd='$did' AND road LIKE '%$doro%'
                            ORDER BY road";
                        }
                        // 검색박스에 값을 넣지 않고 '검색' 버튼을 눌렀을 때의 쿼리
                        else if ($doro == null) {
                            $query = "SELECT distinct(road)
                            FROM road_code
                            WHERE scd='$sgid' and dongcd='$did'
                            ORDER BY road";
                        }
                        // 읍면동명에 값이 존재하지 않을 때의 쿼리(검색 박스에는 입력된 상태-도로명)
                        else if ($did == -1) {
                            $query = "SELECT distinct (road)
                            FROM road_code
                            WHERE scd='$sgid' and road LIKE '%$doro%'
                            ORDER BY road";
                        }

                        $stid = oparse($query);
                        oci_execute($stid) ;
                        ?>
                        
<!--                        // 검색 버튼을 누른 후(or 누름과 동시에) 적용 되는 결과-->
                   <input type="submit" value="검 색" onchange="frmRoadCode.submit()">
                        <?php
                        if ($doro!=null){
                            while($row = oci_fetch_assoc($stid)){
                                ?>
                            <tr><td>
                                <?php
                              echo $row['ROAD'] ?>
                                </td></tr>
                                <?php
                            }
                        }
                        else {
                            while($row = oci_fetch_assoc($stid)) {
                                ?>
                            <tr><td>
                                <?php
                                echo $row['ROAD'];
                                ?>
                                </td></tr>
                        <?php
                            }
                        }
                        ?>

                   </td>
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
    </body>
<?PHP
//echo "sdid:". $sdid;
//echo "sgid:". $sgid;
//echo "did:". $did;
//echo "doro:". $doro;
//?>
</html>