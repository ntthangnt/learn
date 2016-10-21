<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
          <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
            
            .red{
                color: red;
            }
            .blue{
                color:blue;
            }
            .pink{
                color:pink;
            }
        </style>
        
        <script language="javascript">
            $(document).ready(function()
            {
           
                function display_html(num)
                {
                    var html = '';
  
                    html += '<table border="1" cellpadding="5">';
                        html += '<tr>';
                            html += '<td>Num</td>';
                            html += '<td>Status</td>';
                        html += '</tr>';
  
                    for (var i = 0; i < num; i++){
                        html += '<tr>';
                            html += '<td>'+(i+1)+'</td>';
                            html += '<td id="waitting'+i+'" class="pink">Waitting...</td>';
                        html += '</tr>';
                    }
                    html += '</table>'
  
                    $('#results').html(html);
                }
                 
             
                function send_ajax(num, index)
                {
                    if (index > (num - 1)){
                        return false;
                    }
 
               
                    $('#waitting'+index).removeClass('pink').addClass('red').html('Sending...');
 
                
                    $.ajax({
                        url : '/insert_update/public/run',
                        type : 'get',
//                        dataType : 'text',
                        data: {'text':$('input[name=text]').val()},
                        success : function(data)
                        {
                            console.log(data);
                        
                            $('#waitting'+index).removeClass('red').addClass('blue');
                            $('#waitting'+index).html('Finished');
                        }
                    })
                    .always(function(){
    
                        send_ajax(num, ++index);
                    });
                }
                  
                $('#send-request').click(function()
                {   
                    var num = parseInt($('#num-thread').val());
 
                    $(this).remove();
                    $('#num-thread').remove();
 
                    display_html(num);
 
                    send_ajax(num, 0);
                });
            });
        </script>
    </head>
    <body>
        <form action="/insert_update/public/process" method="post" enctype="multipart/form-data">
    <input type="submit" value="Run process" name="submit">
    <input type="text" id="num-thread" name="text" value="10"/>
        <input type="button" id="send-request" value="Send"/>
        <div id="results"></div>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
</form>
    
<div class="container">
  <div class="progress">
    <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:70%">
      70%
    </div>
  </div>
</div>   
    </body>
</html>
