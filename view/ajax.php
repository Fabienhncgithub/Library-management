<?php
//POST - modification DB
//            function functionjs(){
//           console.log($('#idToDelete').val());
//           
//           $.post("rental/deleteAllJS",{rentdelete:$('#idToDelete').val()},function(data){
//               console.log(data);
//               location.reload();
//           });
//            }
//                public function deleteAllJS() {
//        if(isset($_POST["rentdelete"])){
//           $rent= Rental::get_rental_by_user($_POST["rentdelete"]);
//           foreach ($rent as $r){
//               $r->clear();
//           }
//        }
//    }
 //GET
//        public function deleteAllJS() {
//        if(isset($_GET["param1"])){
//           $rent= Rental::get_rental_by_user($_GET["param1"]);
//           foreach ($rent as $r){
//               $r->clear();
//           }
//        }
//               function functionjs(){
//           console.log($('#idToDelete').val());
//           $.get("rental/deleteAllJS/"+$('#idToDelete').val(),function(data){
//               console.log(data);
//               location.reload()
//           });
//            }
//            BOUTON
//            <input id="idToDelete" type='hidden' name='memberclearbasket' value='<?= $smember->id ?>' >
//              <input type="submit" value="Effacer JS"   name="new" onclick="functionjs()">
//            