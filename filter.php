<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
   <title>Reviews</title>
</head>
<body>
   <div class="container mt-4">
      <div class="row d-flex justify-content-around">
         <div class="col-lg-8">
            <h2>Reviews</h3>
            <table class="table table-striped table-bordered">
               <thead>
                  <tr>
                     <th scope="col">#</th>
                     <th scope="col">Text</th>
                     <th scope="col">Rating</th>
                     <th scope="col">Date</th>
                  </tr>
               </thead>
               <tbody id="tbody">

               <?php 

                  $reviews = json_decode(file_get_contents("reviews.json"), false);
                  
                  foreach($reviews as $key => $value){
                     $key = $key + 1;
                     echo '<tr>';
                        echo '<th>'.$key.'</th>';
                        echo '<td>'.$value->reviewText.'</td>';
                        echo '<td>'.$value->rating.'</td>';
                        echo '<td>'.$value->reviewCreatedOnDate.'</td>';
                     echo '</tr>';
                  }

               ?>
                 
               </tbody>
            </table>
            <br>


         </div>

         <div class="col-md-3">
            <h3>Filter Reviews</h3>
            <form method="POST" class="mw-5" id="form">
      
               <div class="form-group">
                  <label for="rating">Order by rating:</label><br>
                  <select class="form-control" name="rating" id="rating">
                     <option value="Highest First">Highest First</option>
                     <option value="Lowest First">Lowest First</option>
                  </select>
               </div>
      
               <div class="form-group">
                  <label for="min">Minimum rating:</label><br>
                  <select class="form-control" name="min" id="min">
                     <option value="5">5</option>
                     <option value="4">4</option>
                     <option value="3">3</option>
                     <option value="2">2</option>
                     <option value="1">1</option>
                  </select>
               </div>
      
               <div class="form-group">
                  <label for="date">Order by date:</label><br>
                  <select class="form-control" name="date" id="date">
                     <option value="Newest First">Newest First</option>
                     <option value="Oldest First">Oldest First</option>
                  </select>
                  
               </div>
               
               <div class="form-group">
                  <label for="text">Prioritize by text:</label><br>
                  <select class="form-control" name="text" id="text">
                     <option value="Yes">Yes</option>
                     <option value="No">No</option>
                  </select>
               </div>
      
               <input type="submit" value="Filter" class="btn btn-primary">
              
               <?php 

                  $result = array();
                  $withText = array();
                  $withoutText = array();

                  $rating = $_POST['rating'];
                  $min = $_POST['min'];
                  $date = $_POST['date'];
                  $text = $_POST['text'];
                  $msg = "Rating: ".$rating." Min: ".$min." Date: ".$date." Text: ".$text." ";
                  echo $msg;

                  // echo gettype($text);
                  foreach($reviews as $key => $value){
                     if ($value->rating >= $min) {
                        if ($text === "No") {
                           array_push($result, $value);
                        }elseif($text === "Yes"){
                           if(strlen($value->reviewText) >= 1){
                              array_push($withText, $value);
                           }else{
                              array_push($withoutText, $value);
                           }
                        }
                     }
                  }

                  // Sort by rating
                  if($rating === "Highest First"){
                     usort($result, function($a, $b){
                        return $a->rating < $b->rating;
                     });
                     usort($withText, function($a, $b){
                        return $a->rating < $b->rating;
                     });
                     usort($withoutText, function($a, $b){
                        return $a->rating < $b->rating;
                     });
                  }elseif($rating === "Lowest First"){
                     usort($result, function($a, $b){
                        return $a->rating > $b->rating;
                     });
                     usort($withText, function($a, $b){
                        return $a->rating > $b->rating;
                     });
                     usort($withoutText, function($a, $b){
                        return $a->rating > $b->rating;
                     });
                  }

                  // Sort by date
                  if($date === "Newest First"){
                     usort($result, function($a, $b){
                        return $a->reviewCreatedOnDate < $b->reviewCreatedOnDate;
                     });
                     usort($withText, function($a, $b){
                        return $a->reviewCreatedOnDate < $b->reviewCreatedOnDate;
                     });
                     usort($withoutText, function($a, $b){
                        return $a->reviewCreatedOnDate < $b->reviewCreatedOnDate;
                     });
                  }elseif($date === "Oldest First"){
                     usort($result, function($a, $b){
                        return $a->reviewCreatedOnDate > $b->reviewCreatedOnDate;
                     });
                     usort($withText, function($a, $b){
                        return $a->reviewCreatedOnDate > $b->reviewCreatedOnDate;
                     });
                     usort($withoutText, function($a, $b){
                        return $a->reviewCreatedOnDate > $b->reviewCreatedOnDate;
                     });
                  }


                  
                  


                  if(count($result) > 0){
                     foreach($result as $key=>$value){
                        echo '<li>'.$value->rating.' - '.$value->reviewText.' - '.$value->reviewCreatedOnDate.'</li>';
                     }
                  }else{
                     foreach($withText as $key=>$value){
                        echo '<li>'.$value->rating.' - '.$value->reviewText.' - '.$value->reviewCreatedOnDate.'</li>';
                     }
                     foreach($withoutText as $key=>$value){
                        echo '<li>'.$value->rating.' - '.$value->reviewText.' - '.$value->reviewCreatedOnDate.'</li>';
                     }
                  }
                  print_r(count($withText));
                  print_r(count($withoutText));
                  print_r(count($result));
                  

                  



               ?>

               <script>
                  const form = document.getElementById('form');
                  const tbody = document.getElementById('tbody');
                  var result = '<?php echo json_encode($result); ?>'
                  var withText = '<?php echo json_encode($withText); ?>'
                  var withoutText = '<?php echo json_encode($withoutText); ?>'
                  console.log(withText);
                  console.log(withoutText);
                  console.log(result);
                  
                  
                  result = JSON.parse(result);
                  withText = JSON.parse(withText);
                  withoutText = JSON.parse(withoutText);
                  console.log(withText.length);
                  console.log(withoutText.length);
                  console.log(result.length);

                  for ( var i in result){
                     console.log(result[i]);
                  }

                 var output;
                  if(result.length > 0){
                     tbody.innerHTML = ""
                     for(var i=0; i<result.length; i++){
                        output += `<tr>
                        <th>${i+1}</th>
                        <td>${result[i]['reviewText']}</td>
                        <td>${result[i]['rating']}</td>
                        <td>${result[i]['reviewCreatedOnDate']}</td>
                        </tr>`
                     }
                  }else{
                     tbody.innerHTML = ""
                     for(var i=0; i<withText.length; i++){
                        output += `<tr>
                        <th>${i+1}</th>
                        <td>${withText[i]['reviewText']}</td>
                        <td>${withText[i]['rating']}</td>
                        <td>${withText[i]['reviewCreatedOnDate']}</td>
                        </tr>`
                     }
                     for(var i=0; i<withoutText.length; i++){
                        output += `<tr>
                        <th>${i+1}</th>
                        <td>${withoutText[i]['reviewText']}</td>
                        <td>${withoutText[i]['rating']}</td>
                        <td>${withoutText[i]['reviewCreatedOnDate']}</td>
                        </tr>`
                     }
                  }

                  

                 if(withText.length > 0 || withoutText.length > 0 || result.length > 0){
                     tbody.innerHTML = output
                 }
                  

               </script>

            </form>
         </div>

      </div>
      <br>
   </div>


   
</body>
</html>