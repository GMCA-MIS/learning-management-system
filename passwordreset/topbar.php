
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.7.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.7.2/dist/js/bootstrap.min.js"></script>
</head>
<body>
<header class ="bar">

    <div class="logoPic">
            <img src="../img/gmlogo.png" alt="logo">
                <a href ="../login.php" class="logo" style="text-decoration: none;">
                    <span>Golden Minds Colleges and Academy</span>
                    <p class="subtitle">Management Information System</p>
                </a>
        </div>
    </header>
    
</body>
</html>
	
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;600;700&display=swap');
*{
    padding: 0;
    margin: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
    text-decoration: none;
    list-style: none;
}

.bar{
  position: relative;
  width: 100%;
  height: 50px;
  top: 0; 
  right: 0;
  z-index: 1;
  display: flex;
  align-items: center;
  justify-content: space-between;
  background: #361e12 !important;
  background-size: cover;
  transition: transform 1s ease, opacity 1s ease;
  background: rgba(23, 24, 32, 0.95);
  opacity: 1;
  padding: 33px 10%;
  transition: all .50s ease; 
}

.logoPic{
  display: flex;
}

.logoPic img{
  height: 50px;
  margin-right: 10px;
  border-radius: 50%;
  margin-top: 10px;
}

.logo{
  display: flex;
  flex-direction: column;
}

.logo span{
  color: white;
  margin-top: 10px;
  font-size: 1.2rem;
  font-weight: 600;
}

.logo .subtitle{
  margin-top: 0px;
  color: bisque;
  font-size: 0.9rem;
}

.logBar{
  display: flex;
  align-items: center;
}

.logBar a{
  margin-right: 25px;
  color: white;
  font-size: 1.1rem;
  font-weight: 500;
  transition: all .50 ease;
}

.user{
  display: flex;
  align-items: center;
}

.user i {
  color: bisque;
  font-size: 21px;
  margin-right: 7px;
}



.logBar a:hover{
 color: #dba61e;
}

@media (max-width: 650px) {
  
  .logo .subtitle{
      font-size: 12px;
      margin-top: 3px;
  }

  .logo span{
      font-size: 1.3rem;
      font-weight: 600;
  }

  .logoPic img{
      height: 63px;
      margin-top: 3px;
  }

  .logBar a{
      display: none;
  }
}


/* Style the dropdown container */
.user-dropdown {
  position: relative;
  display: inline-block;
}

/* Style the dropdown content (hidden by default) */
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #001653;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

/* Style the dropdown links */
.dropdown-content a {
  color: white;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

/* Change color on hover */
.dropdown-content a:hover {
  background-color: #110edf;
}



</style>
    
