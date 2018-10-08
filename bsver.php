<?php
   session_start();
   if($_SESSION['log'] != 'login'){
      header('Location:NEW.html');
      exit('尚未登入<a href="NEW.html">回首頁</a>');
}
    require_once('config.php');
    $i = 0;
?>
<!doctype html>
<html>
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="bsver.css">
    <title>期货</title>
  </head>
  <body>
    <div class="zzz position-fixed col-6 offset-3 h-50 bg-warning margin-top-10 justify-content-center align-items-center d-none">
      <h1 class="text-center margin-top-10"></h1>
      <div class="row justify-content-around align-items-center col margin-top-10">
        <button type="button" class="btn btn-danger btn-lg" onclick="$('.zzz').addClass('d-none');">取消</button>
        <button type="button" class="btn btn-success btn-lg changeO" onclick="$('.zzz').addClass('d-none');">确定</button>
      </div>
   </div>
   <div class="position-fixed col-1 bg-light h-100 px-0 pt-3">
    <button type="button" class="col h2 btn btn-info btn-lg font-weight-bold" onclick="addNew();">新增</button>
    <button type="button" class="col h2 btn btn-info btn-lg font-weight-bold" onclick="location.href='danielwu.php'">旧版</button>
  </div>
  <div class="border col-11 offset-1">
  <table class="table table-hover table-sm">
  <thead>
    <tr>
      <th scope="col">序号</th>
      <th scope="col">id</th>
      <th scope="col">appid</th>
      <th scope="col">appname</th>
      <th scope="col">开启状态</th>
      <th scope="col">跳转链接</th>
      <th scope="col">status</th>
      <th scope="col">desc</th>
      <th scope="col">说明</th>
      <th scope="col">操作</th>
      
    </tr>
  </thead>
  <tbody>
  <?php
            $sql = "SELECT * FROM danielwu";
            $stmt = $conn->prepare($sql);
            // $stmt->bindParam(1,$myip,PDO::PARAM_STR,15);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach( $result as $n ){
                $i++;
                echo '<tr><th scope="row">'.$i.'</th>';
                foreach( $n as $key=>$nn ){
                    if( $key == 'id' ){
                      echo '<td class="id">'.$nn.'</td>';
                      $id = $nn;
                      
                    }elseif( $key == 'isshowwap' ){
                      $op = $nn == '1' ? '' : 'd-none' ;
                      $clo = $nn == '1' ?  'd-none' : '' ;
                      
                      echo '<td class="switchStatus'.$id.'"><div class="text-success font-weight-bold '.$op.'">开启中</div><div class="text-danger font-weight-bold '.$clo.'">关闭</div></td>';

                    }else{
                      echo '<td class="dblclick"><div>'.$nn.'</div><input type="text" class="d-none form-control" value="'.$nn.'"></td>';
                    }
                }
                
                echo '<td class="buttonArea'.$i.'"><button type="button" onclick="changeAlert( '.$i.','.$id.', \'isshowwap\' ,1)" class="btn btn-success mx-2 '.$clo.'">开启</button>';
                echo '<button type="button" onclick="changeAlert( '.$i.','.$id.', \'isshowwap\' ,0)" class="btn btn-danger mx-2 '.$op.'">关闭</button>';
                echo '<button type="button" class="btn btn-secondary" onclick="changeAlert('.$i.','.$id.', 0 ,\'delete\')">删除</button></td></tr>';
            }
            
    ?>
  </tbody>
</table>
</div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script>
      function tagType( newNumber ){
        switch( newNumber ){
          case 2:
            return 'appid';
            break;
          case 3:
            return 'appname';
            break;
          case 5:
            return 'wapurl';
            break;
          case 6:
            return 'status';
            break;
          case 7:
            return 'qwe';
            break;
          case 8:
            return 'tt';
        }

      }
      $('.dblclick').dblclick(function(){
        $(this).children('div').addClass('d-none');
        $(this).children('input').removeClass('d-none').focus();
      });


      $('input').keydown(function(event){
          
        if ( event.which == 13 ){
          var self = $(this);
          var inputVal = $(this).val();
          var newCol = $(this).parent().index();
          var newType = tagType(newCol);
          var newId = $(this).parent().prevAll('.id').text();
          // console.log(newCol+' '+newType+' '+inputVal+' '+newId+' '+self);
          $.post('switch.php',{
            id : newId , sqlCol : newType , sqlVal : inputVal
          },function(data){
            if( data = 'success' ){
              self.addClass('d-none');
              self.prev().removeClass('d-none').text(inputVal);
          console.log(newCol+' '+newType+' '+inputVal+' '+newId);
              console.log(data);
            }
          });

        }
      });

      function changeAlert( self , newId , newSqlCol , newSqlVal ){
        var changeWord = newSqlVal == 'delete' ? '确定要删除？' : newSqlVal == 1 ? '确定要开启？' : '确定要关闭？';
        $('.zzz>h1').text(changeWord);
        $('.changeO').attr('onclick','');
        if( newSqlVal == 'delete' ){
          $('.changeO').attr('onclick','del('+self+','+newId+')');
        }else{
          $('.changeO').attr('onclick','newSwitch('+self+','+newId+',"'+newSqlCol+'",'+newSqlVal+')');
        }
        $('.zzz').removeClass('d-none');

      }

      function newSwitch( self , newId , newSqlCol , newSqlVal ){
        var newChange = newSqlVal == 1 ? true : false ;
        var newSelf = $('.buttonArea'+self).children().eq(newSqlVal) ;
        var newSelfSibling = newChange ? newSelf.prev() : newSelf.next();
        var newStatusOne = newChange ? $('.switchStatus'+newId).children('div:first') : $('.switchStatus'+newId).children('div:last') ;
        var newStatusTwo = !newChange ? $('.switchStatus'+newId).children('div:first') : $('.switchStatus'+newId).children('div:last') ;
        console.log(newSelf);
        $.ajax({
          url: "switch.php",
          type: "POST",
          data: { id : newId , sqlCol : newSqlCol , sqlVal : newSqlVal },
          success : function(result){
            if( result == 'success'){
              newSelfSibling.addClass('d-none');
              newSelf.removeClass('d-none');
              newStatusOne.removeClass('d-none');
              newStatusTwo.addClass('d-none');
              $('.zzz').addClass('d-none');
            }
          }
         });
      }
      var lastId = Number($("tr:last").children("td:first").text())+1;
      function addNew(){
        var newNum = Number($("tr:last").children("th").text())+1;
        var newtext = '还未输入内容';
        $.post('add.php',{
            add : 'add'
        },function(data){
          console.log(data);
          if( data == 'success'){
            var newChild = '<tr><th>'+newNum+'</th>';
            for(var lo = 0; lo < 9; lo = lo + 1){
               if( lo == 0){
                  newChild += '<td class="id">'+lastId+'</td>';
               }else if( lo == 3 ){
                  newChild += '<td class="switchStatus'+lastId+'"><div class="text-success font-weight-bold d-none">开启中</div><div class="text-danger font-weight-bold ">关闭</div></td>'
               }else if( lo == 8 ){
                  newChild += '<td class="buttonArea'+newNum+'"><button type="button" onclick="changeAlert( '+newNum+','+lastId+', \'isshowwap\' ,1)" class="btn btn-success mx-2">开启</button>';
                  newChild += '<button type="button" onclick="changeAlert( '+newNum+','+lastId+', \'isshowwap\' ,0)" class="btn btn-danger mx-2 d-none">关闭</button>';
                  newChild += '<button type="button" class="btn btn-secondary" onclick="changeAlert('+newNum+','+lastId+', 0 ,\'delete\')">删除</button></td></tr>';
               }else{
                  newChild += '<td class="dblclick">'+newtext+'</td>';
               }
             }
             $("tbody").append(newChild);
             lastId += 1;
           }
        });
      }
      function del( self , newId ){
        var delTarget = $('tr').eq(self);
        $.post('del.php',{
          id : newId
        },function(data){
          if( data == 'success'){
            delTarget.remove();

            $('.zzz').addClass('d-none');
          }
        });
      }
    </script>
  </body>
</html>