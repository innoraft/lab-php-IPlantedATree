<?php
include('conn.php');
$sql = "SELECT * FROM userContent";
$rs = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
<style type="text/css">
	/* Media Queries */
/* Card sizing */
/* Colors */
/* Calculations */
/* Placeholders */
@media (min-width: 1000px) {
  #timeline .demo-card:nth-child(odd) .head::after, #timeline .demo-card:nth-child(even) .head::after {
    position: absolute;
    content: "";
    width: 0;
    height: 0;
    border-top: 15px solid transparent;
    border-bottom: 15px solid transparent;
  }

  #timeline .demo-card:nth-child(odd) .head::before, #timeline .demo-card:nth-child(even) .head::before {
    position: absolute;
    content: "";
    width: 9px;
    height: 9px;
    background-color: #bdbdbd;
    border-radius: 9px;
    box-shadow: 0px 0px 2px 8px #f7f7f7;
  }
}
/* Some Cool Stuff */
.demo-card:nth-child(1) {
  order: 1;
}

.demo-card:nth-child(2) {
  order: 4;
}

.demo-card:nth-child(3) {
  order: 2;
}

.demo-card:nth-child(4) {
  order: 5;
}

.demo-card:nth-child(5) {
  order: 3;
}

.demo-card:nth-child(6) {
  order: 6;
}

/* Border Box */
* {
  box-sizing: border-box;
}

/* Fonts */
body {
  font-family: Roboto;
}

#timeline {
  padding: 100px 0;
  background: #f7f7f7;
  border-top: 1px solid rgba(191, 191, 191, 0.4);
  border-bottom: 1px solid rgba(191, 191, 191, 0.4);
}
#timeline h1 {
  text-align: center;
  font-size: 3rem;
  font-weight: 200;
  margin-bottom: 20px;
}
#timeline p.leader {
  text-align: center;
  max-width: 90%;
  margin: auto;
  margin-bottom: 45px;
}
#timeline .demo-card-wrapper {
  position: relative;
  margin: auto;
}
@media (min-width: 1000px) {
  #timeline .demo-card-wrapper {
    display: flex;
    flex-flow: column wrap;
    width: 1170px;
    height: 1650px;
    margin: 0 auto;
  }
}
#timeline .demo-card-wrapper::after {
  z-index: 1;
  content: "";
  position: absolute;
  top: 0;
  bottom: 0;
  left: 50%;
  border-left: 1px solid rgba(191, 191, 191, 0.4);
}
@media (min-width: 1000px) {
  #timeline .demo-card-wrapper::after {
    border-left: 1px solid #bdbdbd;
  }
}
#timeline .demo-card {
  position: relative;
  display: block;
  margin: 10px auto 80px;
  max-width: 94%;
  z-index: 2;
}
@media (min-width: 480px) {
  #timeline .demo-card {
    max-width: 60%;
    box-shadow: 0px 1px 22px 4px rgba(0, 0, 0, 0.07);
  }
}
@media (min-width: 720px) {
  #timeline .demo-card {
    max-width: 40%;
  }
}
@media (min-width: 1000px) {
  #timeline .demo-card {
    max-width: 450px;
    height: 400px;
    margin: 90px;
    margin-top: 45px;
    margin-bottom: 45px;
  }
  #timeline .demo-card:nth-child(odd) {
    margin-right: 45px;
  }
  #timeline .demo-card:nth-child(odd) .head::after {
    border-left-width: 15px;
    border-left-style: solid;
    left: 100%;
  }
  #timeline .demo-card:nth-child(odd) .head::before {
    left: 491.5px;
  }
  #timeline .demo-card:nth-child(even) {
    margin-left: 45px;
  }
  #timeline .demo-card:nth-child(even) .head::after {
    border-right-width: 15px;
    border-right-style: solid;
    right: 100%;
  }
  #timeline .demo-card:nth-child(even) .head::before {
    right: 489.5px;
  }
  #timeline .demo-card:nth-child(2) {
    margin-top: 180px;
  }
}
#timeline .demo-card .head {
  position: relative;
  display: flex;
  align-items: center;
  color: #fff;
  font-weight: 400;
}
#timeline .demo-card .head .number-box {
  display: inline;
  float: left;
  margin: 15px;
  padding: 10px;
  font-size: 35px;
  line-height: 35px;
  font-weight: 600;
  background: rgba(0, 0, 0, 0.17);
}
#timeline .demo-card .head h2 {
  text-transform: uppercase;
  font-size: 1.3rem;
  font-weight: inherit;
  letter-spacing: 2px;
  margin: 0;
  padding-bottom: 6px;
  line-height: 1rem;
}
@media (min-width: 480px) {
  #timeline .demo-card .head h2 {
    font-size: 165%;
    line-height: 1.2rem;
  }
}
#timeline .demo-card .head h2 span {
  display: block;
  font-size: 0.6rem;
  margin: 0;
}
@media (min-width: 480px) {
  #timeline .demo-card .head h2 span {
    font-size: 0.8rem;
  }
}
#timeline .demo-card .body {
  background: #fff;
  border: 1px solid rgba(191, 191, 191, 0.4);
  border-top: 0;
  padding: 15px;
}
@media (min-width: 1000px) {
  #timeline .demo-card .body {
    height: 315px;
  }
}
#timeline .demo-card .body p {
  font-size: 14px;
  line-height: 18px;
  margin-bottom: 15px;
}
#timeline .demo-card .body img {
  display: block;
  width: 100%;
}
#timeline .demo-card--step1 {
  background-color: #46b8e9;
}
#timeline .demo-card--step1 .head::after {
  border-color: #46b8e9;
}
#timeline .demo-card--step2 {
  background-color: #3ee9d1;
}
#timeline .demo-card--step2 .head::after {
  border-color: #3ee9d1;
}
#timeline .demo-card--step3 {
  background-color: #ce43eb;
}
#timeline .demo-card--step3 .head::after {
  border-color: #ce43eb;
}
#timeline .demo-card--step4 {
  background-color: #4d92eb;
}
#timeline .demo-card--step4 .head::after {
  border-color: #4d92eb;
}
#timeline .demo-card--step5 {
  background-color: #46b8e9;
}
#timeline .demo-card--step5 .head::after {
  border-color: #46b8e9;
}

</style>
</head>
<body>
<section id=timeline>
	<h1>A Flexbox Timeline</h1>
	<p class="leader">All cards must be the same height and width for space calculations on large screens.</p>
  <div class="demo-card-wrapper">
<?php
  $i = 0;
  while($row = $rs->fetch_assoc()){
    $i++;
    if($i%6 == 0)
      break;
?>

    <div class="demo-card demo-card--step<?php echo $i;?>">
      <div class="head">
        <div class="number-box">
          <span><?php echo $i;?></span>
        </div>
        <h2><span class="small">Subtitle</span> Technology</h2>
      </div>
      <div class="body">
        <p><?php echo $row['description'];?></p>
        <img src="<?php echo $row['picture_url'];?>" alt="Image">
      </div>
    </div>
  
<?php
  }
?>
</div>

<!-- 
		<div class="demo-card demo-card--step2">
			<div class="head">
				<div class="number-box">
					<span>02</span>
				</div>
				<h2><span class="small">Subtitle</span> Confidence</h2>
			</div>
			<div class="body">
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Soluta reiciendis deserunt doloribus consequatur, laudantium odio dolorum laboriosam.</p>
				<img src="http://placehold.it/1000x500" alt="Graphic">
			</div>
		</div>

		<div class="demo-card demo-card--step3">
			<div class="head">
				<div class="number-box">
					<span>03</span>
				</div>
				<h2><span class="small">Subtitle</span> Adaptation</h2>
			</div>
			<div class="body">
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Soluta reiciendis deserunt doloribus consequatur, laudantium odio dolorum laboriosam.</p>
				<img src="http://placehold.it/1000x500" alt="Graphic">
			</div>
		</div>

		<div class="demo-card demo-card--step4">
			<div class="head">
				<div class="number-box">
					<span>04</span>
				</div>
				<h2><span class="small">Subtitle</span> Consistency</h2>
			</div>
			<div class="body">
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Soluta reiciendis deserunt doloribus consequatur, laudantium odio dolorum laboriosam.</p>
				<img src="http://placehold.it/1000x500" alt="Graphic">
			</div>
		</div>

		<div class="demo-card f">
			<div class="head">
				<div class="number-box">
					<span>05</span>
				</div>
				<h2><span class="small">Subtitle</span> Conversion</h2>
			</div>
			<div class="body">
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Soluta reiciendis deserunt doloribus consequatur, laudantium odio dolorum laboriosam.</p>
				<img src="http://placehold.it/1000x500" alt="Graphic">
			</div>
		</div>
     
	</div>
-->
</section>
</body>
</html>