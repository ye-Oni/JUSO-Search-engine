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
    function sido() {
        // 시도명 조회 쿼리문
        $query = "SELECT DISTINCT(sido)
        FROM building
        ORDER BY sido";

        $stid = oparse($query);
        oci_execute($stid);
        
        // 시도 ID 값 저장
        if(isset($_POST['$sido'])){
        $sido = $_POST['$sido'];
}
?>
    <td style="border:1px dashed black; padding:10px;">
        <select id="sido" name="sido" width="10%" onchange="frmBuilding.submit()";>
        
            <option value="-1">▽ 시도명</option>
            <?php
            // 시도 ID로 값을 불러오기
            while($row = oci_fetch_assoc($stid)){
                ?>
                <option value="<?php echo $row['SIDO'] ?>"
                    <?php
                    if($sido == $row['SIDO']) echo "selected='selected'";
                    ?>>
                    <?php echo $row['SIDO'] ?>
                </option>
                <?php
            } echo $sido;
            ?>
        </select>
    </td>

    <?php
    return $sido;
    }



    // * 시군구명 SELECT BOX *
    function gugun($sido) {
        // 시군구명 조회 쿼리문
        $query = "SELECT DISTINCT(gugun)
        FROM building
        WHERE sido = '$sido'
        ORDER BY gugun;";

        $stid = oparse($query);
        oci_execute($stid);
        
        // 시도 ID 값 저장
        if(isset($_POST['gugun'])){
            $gugun = $_POST['gugun'];
    }
?>
    <td style="border:1px dashed black; padding:10px;">
        <select id="gugun" name="gugun" width="10%" onchange="frmBuilding.submit()";>
            <option value="-1">▽  시군구명</option>
            <?php
            // 시군구 ID로 값을 불러오기
            while($row = oci_fetch_assoc($stid)){
                ?>
                <option value="<?php echo $row['GUGUN'] ?>"
                    <?php
                    if($gugun == $row['GUGUN']) echo "selected='selected'";
                    ?>>
                    <?php echo $row['GUGUN'] ?>
                </option>
                <?php
            }
            ?>
        </select>
    </td>
    <?php
        return $gugun;
    }



    // * 읍면동명 SELECT BOX *
    function dong($sido, $gugun) {
        // 읍면동명 조회 쿼리문
        $query = "SELECT DISTINCT(dong)
            FROM building
            WHERE sido = '$sido' and gugun = '$gugun'
            ORDER BY dong;";

        $stid = oparse($query);
        oci_execute($stid);

        // 읍면동명 ID 값 저장
        if(isset($_POST['dong'])){
            $dong = $_POST['dong'];
        }
        ?>
        <td style="border:1px dashed black; padding:10px;">
            <select id="dong" name="dong" width="10%" onchange="frmBuilding.submit()";>
                <option value="-1">▽ 읍면동명</option>
                <?php
                // 읍면동 ID로 값을 불러오기
                while($row = oci_fetch_assoc($stid)){
                    ?>
                    <option value="<?php echo $row['DONG'] ?>"
                        <?php
                        if($gugun == $row['DONG']) echo "selected='selected'";
                        ?>>
                        <?php echo $row['DONG'] ?>
                    </option>
                    <?php
                }
                ?>
            </select>
        </td>
        <?php
        return $dong;
    }
