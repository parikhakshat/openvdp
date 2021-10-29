<?php
	session_start();
    header("Content-type: text/css; charset: UTF-8");
?>
body {
	margin: 0px;
    padding: 0px;
    font-family: Gill Sans,Gill Sans MT,Calibri,sans-serif; 
}
.header {
	width: 100%;
	height: 124.8px;
}

.headerImg {
	width: 30%;
  margin: 0 auto;
}

.user {
	float: left;
	margin-left: -10%;
	overflow-wrap: break-word;
	position: relative;
	width: 200px;
	margin-top: -30%;
}

.profile {
	position: relative;
	float: right;

}
.profileImg { 
	width:50px; 
	height:50px;
	background-color:<?= $_SESSION["color"]; ?>;
    border:5px solid black;    
    border-radius:50%;
    -moz-border-radius:50%;
    -webkit-border-radius:50%;
    position: relative;
} 

.user b {
	font-size: 20px;
}

.dropdown button {
  border: none;
  padding: 0;
  background: none;
}
.dropdown {
position: relative;
  display: inline-block;
  margin-right: 30px;
  float: right;
  margin-top: -102.4px;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {background-color: #ddd;}

.dropdown:hover .dropdown-content {display: block;}

.dropdown:hover .dropbtn {background-color: #3e8e41;}

* {
  box-sizing: border-box;
}

/*the container must be positioned relative:*/
.autocomplete {
  position: relative;
  display: inline-block;
}

input {
  border: 1px solid transparent;
  background-color: #f1f1f1;
  padding: 10px;
  font-size: 16px;
}

input[type=text] {
  background-color: #f1f1f1;
  width: 100%;
}

input[type=submit] {
  background-color: #0011ad;
  border: 2px solid black;
  padding: 10px;
  text-align: center;
  text-decoration: none;
  font-size: 16px;
  color: #fff;
  cursor: pointer;
  margin-left: 10px;
}

input[type=submit]:hover {
  background-color: #539ddb;
  color: white;
}



#autocomplete-items {
  position: absolute;
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
  z-index: 99;
  top: 100%;
  left: 0;
  right: 0;
  overflow-y: scroll;
  height: 200px;
}

#autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff; 
  border-bottom: 1px solid #d4d4d4; 
}

#autocomplete-items div:hover {
  background-color: #e9e9e9; 
}

.autocomplete-active {
  background-color: DodgerBlue !important; 
  color: #ffffff; 
}

.report {
	border-radius: 10px;
	width: 75%;
	min-height: 50px;
	background-color: #D3D3D3;
	padding: 10px;
	margin: 10px;
	text-align: center;
	font-family: Gill Sans,Gill Sans MT,Calibri,sans-serif; 
	border: 2px solid black;
	position: relative;
}

.title {
	position: relative;
	float: left;
}

.status {
	position: relative;
	float: right;
}

.status img {
}

.status b {
	margin-right: 10px;
}

.report a {
	text-decoration: none;
	color: black;
	overflow-wrap: break-word;
}

.reportsList h1 {
	margin: 10px;
}

.creation {
	margin: 10px;
	border-radius: 10px;
	width: 75%;
	min-height: 30px;
	padding: 10px;
	margin: 10px;
	font-family: Gill Sans,Gill Sans MT,Calibri,sans-serif; 
	border: 2px solid black;
	background-color: #D3D3D3;
}

hr {
	margin-top: 15px;
	border: 2px solid black;
}

.creation h1 {
	margin-top: 10px;
}

.footer {
  margin: 10px;
  border-radius: 10px;
  width: 75%;
  min-height: 30px;
  padding: 10px;
  margin: 10px;
  font-family: Gill Sans,Gill Sans MT,Calibri,sans-serif; 
  border: 2px solid black;
  background-color: #D3D3D3;
}
