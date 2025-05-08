<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>complete responsive website desgin tutorial</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- custom css file link  -->

    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    
<!-- header section starts  -->

<header class="header">

    <a href="#" class="logo">  <i class="fas fa-ice-cream text-white"></i> Dreamy Cones</a>

    <nav class="navbar">
        <a href="#home">home</a>
        <a href="#services">services</a>
        <a href="#about">about</a>
       
        <a href="#contact">contact</a>
    </nav>

    <div id="menu-btn" class="fas fa-bars"></div>

</header>

<!-- header section ends -->

<!-- home section starts  -->

<section class="home" id="home">

    <div class="content">
        <h3>ICE CREAM SHOP</h3>
        <P>REVENUE & SPENDING MONITOR</p>
        <a href="login.php" class="btn">Login</a>
    </div>

    <div class="image">
        <img src="ice7.jpg" alt="">
    </div>

    <div class="cloud cloud-1"></div>
    <div class="cloud cloud-2"></div>

</section>

<!-- home section ends -->

<!-- services section starts  -->

<section class="services" id="services">

    <h1 class="heading"> our <span>services</span> </h1>

    <div class="box-container">

        <div class="box">
            <img src="images/s-1.png" alt="">
            <h3> Authentication & User Management</h3>
            <p>User registration and login (PHP session-based or JWT)
            Profile update (change name, email, password)</p>
            <a href="#" class="btn">learn more</a>
        </div>

        <div class="box">
            <img src="images/s-2.png" alt="">
            <h3>Transaction Management</h3>
            <p>Income & Expense Tracking: Add, update, delete transactions
Categorization: Classify transactions (e.g., raw materials, sales, electricity)
Expense Limit Alerts: Notify when exceeding predefined expense limits</p>
            <a href="#" class="btn">learn more</a>
        </div>

        <div class="box">
            <img src="images/s-3.png" alt="">
            <h3>Reporting & Analytics</h3>
            <p>Charts & Graphs: Visualize financial trends (daily, weekly, monthly, yearly)
PDF Report Generation: Generate and download financial reports using FPDF
CSV Export: Export data for external analysis</p>
            <a href="#" class="btn">learn more</a>
        </div>

        <div class="box">
            <img src="images/s-4.png" alt="">
            <h3>Utility Services</h3>
            <p>Currency Converter: Convert transactions into different currencies
Electricity Bill Estimation: Calculate monthly electricity costs
</p>
            <a href="#" class="btn">learn more</a>
        </div>

        <div class="box">
            <img src="images/s-6.png" alt="">
            <h3>Utility Services</h3>
            <p>Notes & Reminders: Store quick notes for financial planning
            Calendar View: Show transaction breakdown per day</p>
            <a href="#" class="btn">learn more</a>
</div>

        <div class="box">
            <img src="images/s-5.png" alt="">
            <h3>Data Backup & Restore</h3>
            <p>Backup MySQL database to prevent data loss
            Restore previous financial records when needed</p>
            <a href="#" class="btn">learn more</a>
        </div>

      

    </div>

</section>

<!-- services section ends -->

<!-- about section starts  -->

<section class="about" id="about">

    <h1 class="heading"> <span>about</span> us </h1>
    
    <div class="row">

        <div class="image">
            <img src="i.jpeg" alt="">
        </div>

        <div class="content">
            <h3 class="title">Ice Cream Revenue & Expense Monitor</h3>
            <p>Is a financial management system designed for ice cream businesses. It helps track income and expenses with categorization, visualize financial trends using charts, and set expense limits. Additional features include electricity bill tracking, currency conversion, report generation (PDF), and a calendar for day-wise transaction insights. Users can manage their profiles and maintain notes for better financial planning. The system ensures an intuitive interface for profitability analysis and business growth.
              </p>
            <a href="#" class="btn">learn more</a>
           
        </div>

    </div>

</section>

<!-- about section ends -->




<!-- contact section starts  -->

<section class="contact" id="contact">

    <h1 class="heading"> <span>contact</span> us </h1>

    <div class="icons-container">
        <div class="icons">
            <i class="fas fa-phone"></i>
            <h3>our number</h3>
            <p>+123-456-7890</p>
            <p>+111-222-3333</p>
        </div>
        <div class="icons">
            <i class="fas fa-envelope"></i>
            <h3>our email</h3>
            <p>dreams_cones@gmail.com</p>
            <p>www.Dreams_cones.com</p>
        </div>
        <div class="icons">
            <i class="fas fa-map-marker-alt"></i>
            <h3>our location</h3>
            <p>tamil nadu,madurai, india - 62005</p>
        </div>
    </div>

  

</section>

<!-- contact section ends -->

<!-- footer section starts  -->

<section class="footer">

    <div class="box-container">
        
      

        <div class="box">
            <h3>quick links</h3>
            <a href="#"> <i class="fas fa-arrow-right"></i> home </a>
            <a href="#"> <i class="fas fa-arrow-right"></i> services </a>
            <a href="#"> <i class="fas fa-arrow-right"></i> about </a>
     
            <a href="#"> <i class="fas fa-arrow-right"></i> contact </a>
        </div>

        <div class="box">
            <h3>our services</h3>
            <a href="#"> <i class="fas fa-check"></i> Authentication & User Management</a>
            <a href="#"> <i class="fas fa-check"></i> Transaction Management </a>
            <a href="#"> <i class="fas fa-check"></i> Reporting & Analytics </a>
            <a href="#"> <i class="fas fa-check"></i> Utility Services </a>
            <a href="#"> <i class="fas fa-check"></i> Data Backup & Restore </a>
        </div>

        <div class="box">
            <h3>follow us</h3>
            <a href="https://facebook.com/freewebsitecode"> <i class="fab fa-facebook-f"></i> facebook </a>
            <a href="#"> <i class="fab fa-twitter"></i> twitter </a>
            <a href="#"> <i class="fab fa-instagram"></i> instagram </a>
            <a href="#"> <i class="fab fa-linkedin"></i> linkedin </a>
            <a href="#"> <i class="fab fa-pinterest"></i> pinterest </a>
        </div>

    </div>

    <div class="credit">created by <span><a href="https://freewebsitecode.com/">DK</a></span> | all rights reserved</div>

</section>

<!-- footer section ends -->

















<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>

<style>
  @import url('https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,600;0,700;1,200;1,300&display=swap');

:root{
    --main-color:#e8786e;
    --black:#555;
    --light-color:#777;
    --bg:#fceae9;
    --border:.1rem solid rgba(0,0,0,.1);
    --box-shadow:0 .5rem 1.5rem rgba(0,0,0,.1);
}

*{
    font-family: 'Nunito', sans-serif;
    margin:0; padding:0;
    box-sizing: border-box;
    outline: none; border:none;
    text-decoration: none;
    text-transform: capitalize;
    transition: all .3s ease-out;
}

html{
    font-size: 62.5%;
    scroll-behavior: smooth;
    scroll-padding-top: 9rem;
    overflow-x: hidden;
}

section{
    padding:2rem 9%;
}

.heading{
    text-align: center;
    padding-bottom: 3rem;
    font-size: 4rem;
    color:var(--black);
}

.heading span{
    color:var(--main-color);
    border-radius: .5rem;
    background: var(--bg);
    padding:0 1.5rem;
}

.btn{
    margin-top: 1rem;
    display: inline-block;
    padding:.8rem 3rem;
    font-size: 1.7rem;
    cursor: pointer;
    color:#fff;
    background:var(--main-color);
    border-radius: .5rem;
    box-shadow: var(--box-shadow);
    position: relative;
    z-index: 0;
    overflow:hidden;
}

.btn::before{
    content: '';
    position: absolute;
    top:0; right:0;
    height: 100%;
    width:0%;
    background:var(--black);
    z-index: -1;
    transition: .2s ease-out;
}

.btn:hover::before{
    left:0;
    width:100%;
}

.header{
    position: fixed;
    top:0; left:0; right: 0;
    z-index: 1000;
    background: #fff;
    box-shadow: var(--box-shadow);
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding:2rem 9%;
}

.header .logo{
    font-size: 2.5rem;
    color:var(--black);
    font-weight: bolder;
}

.header .navbar a{
    font-size: 1.7rem;
    color: var(--light-color);
    margin-left: 2rem;
}

.header .navbar a:hover{
    color:var(--main-color);
}

#menu-btn{
    cursor: pointer;
    font-size: 2.5rem;
    padding:1rem 1.3rem;
    border-radius: .5rem;
    color: var(--main-color);
    background: var(--bg);
    display: none;
}

#menu-btn:hover{
    color: #fff;
    background: var(--main-color);
}

.home{
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap:1.5rem;
    padding-top: 10rem;
    background:var(--bg);
    position: relative;
}

.home .content{
    flex:1 1 45rem;
}

.home .image{
    flex:1 1 45rem;
}

.home .image img{
    width: 100%;
}

.home .content h3{
    font-size: 3.5rem;
    color:var(--black);
    line-height: 1.8;
}

.home .content p{
    font-size: 1.7rem;
    color:var(--light-color);
    line-height: 1.8;
    padding:1rem 0;
}

.home .cloud{
    position: absolute;
    bottom: 0; right: 0; left: 0;
    height: 18rem;
    background-size: 250rem 18rem;
    background:url(../images/cloud.png) repeat-x;
    animation: cloud 10s linear infinite;
}

@keyframes cloud{
    0%{
        background-position-x: 0rem;
    }
    100%{
        background-position-x: -250rem;
    }
}

.home .cloud-1{
    opacity: .5;
    height:20rem;
    background-size: 250rem 20rem;
    animation-direction: reverse;
    animation-duration: 15s;
}

.services .box-container{
    display:grid;
    grid-template-columns: repeat(auto-fit, minmax(27rem, 1fr));
    gap:1.5rem;
}

.services .box-container .box{
    text-align: center;
    border:var(--border);
    box-shadow: var(--box-shadow);
    border-radius: .5rem;
    padding:4rem 2rem;
}

.services .box-container .box img{
    height: 10rem;
}

.services .box-container .box h3{
    color:var(--black);
    font-size: 2.5rem;
    padding-top: 1.5rem;
}

.services .box-container .box p{
    color:var(--light-color);
    font-size: 1.5rem;
    padding:1rem 0;
    line-height: 1.8;
}

.about .row{
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap:1.5rem;
}

.about .row .image{
    flex:1 1 45rem;
    padding: 2rem;
}

.about .row .image img{
    width: 100%;
}

.about .row .content{
    flex:1 1 45rem;
}

.about .row .content .title{
    font-size:3rem;
    color:var(--black);
}

.about .row .content p{
    font-size:1.5rem;
    color:var(--light-color);
    line-height: 1.8;
    padding: 1rem 0;
}

.about .row .content .icons-container{
    display: flex;
    flex-wrap: wrap;
    gap:1rem;
    padding-top: 2rem;
}

.about .row .content .icons-container .icons{
    flex:1 1 15rem;
    border-radius: .5rem;
    border:var(--border);
    padding:1.5rem;
    text-align: center;
}

.about .row .content .icons-container .icons i{
    border-radius: 50%;
    background: var(--bg);
    color:var(--main-color);
    height: 5rem;
    width: 5rem;
    line-height: 5rem;
    font-size: 2rem;
}

.about .row .content .icons-container .icons h3{
    color:var(--light-color);
    font-size: 1.6rem;
    padding-top: 1rem;
}

.portfolio .box-container{
    display:grid;
    grid-template-columns: repeat(auto-fit, minmax(27rem, 1fr));
    gap:1.5rem;
}

.portfolio .box-container .box{
    height: 30rem;
    border-radius: .5rem;
    overflow:hidden;
    position: relative;
    box-shadow: var(--box-shadow);
}

.portfolio .box-container .box img{
    height: 100%;
    width: 100%;
    object-fit: cover;
}

.portfolio .box-container .box span{
    position: absolute;
    top:1rem; right: 2rem;
    font-weight: bolder;
    font-size: 5rem;
    color:var(--black);
}

.portfolio .box-container .box .content{
    height: 100%;
    width: 100%;
    position: absolute;
    top:6rem; left: 0;
    transition-delay: .3s;
    display: flex;
    flex-flow: column;
    align-items: center;
    justify-content: center;
    opacity: 0;
}

.portfolio .box-container .box:hover .content{
    top:0; 
    opacity: 1;
}

.portfolio .box-container .box .content h3{
    font-size: 2.5rem;
    padding-bottom: .5rem;
    color:var(--black);
}

.portfolio .box-container .box .content p{
    font-size: 1.5rem;
    color:var(--light-color);
}

.portfolio .box-container .box::before{
    height: 100%;
    width: 100%;
    content: '';
    position: absolute;
    top:0; left: 0;
    background: #fff;
    clip-path: circle(30% at 93% 0);
    transition: .3s linear;
}

.portfolio .box-container .box:hover::before{
    clip-path: circle(100%);
}

.pricing .box-container{
    display:grid;
    grid-template-columns: repeat(auto-fit, minmax(30rem, 1fr));
    gap:1.5rem;
}

.pricing .box-container .box{
    text-align: center;
    padding: 2rem;
    border-radius: .5rem;
    border:var(--border);
    box-shadow: var(--box-shadow);
}

.pricing .box-container .box h3{
    color:var(--black);
    font-size: 2.5rem;
}

.pricing .box-container .box img{
    margin:2.5rem 0;
    height: 15rem;
}

.pricing .box-container .box .price{
    font-size: 4rem;
    font-weight: bolder;
    color: var(--main-color);
}

.pricing .box-container .box .price span{
    font-size: 2rem;
    font-weight: lighter;
}

.pricing .box-container .box ul{
    padding: 1rem 0;
    list-style: none;
}

.pricing .box-container .box ul li{
    padding: 1rem 0;
    font-size: 1.7rem;
    color: var(--light-color);
}

.review .box-container{
    display:grid;
    grid-template-columns: repeat(auto-fit, minmax(30rem, 1fr));
    gap:1.5rem;
}

.review .box-container .box{
    padding: 2rem;
    border-radius: .5rem;
    border:var(--border);
    box-shadow: var(--box-shadow);
}

.review .box-container .box .user{
    display: flex;
    align-items: center;
    padding-bottom: 1rem;
}

.review .box-container .box .user img{
    height: 7rem;
    width: 7rem;
    border-radius: 50%;
    margin-right: 1rem;
}

.review .box-container .box .user h3{
    font-size: 2.2rem;
    color: var(--black);
    padding-bottom: .5rem;
}

.review .box-container .box .user .stars i{
    font-size: 1.5rem;
    color: var(--main-color);
}

.review .box-container .box .fa-quote-right{
    margin-left: auto;
    font-size: 5rem;
    color:var(--bg);
}

.review .box-container .box p{
    padding-top: 1rem;
    font-size: 1.6rem;
    line-height: 1.8;
    color: var(--light-color);
    font-style: italic;
}

.contact .icons-container{
    display:grid;
    grid-template-columns: repeat(auto-fit, minmax(30rem, 1fr));
    gap:1.5rem;
}

.contact .icons-container .icons{
    padding: 2.5rem;
    text-align: center;
    border: var(--border);
    border-radius: .5rem;
    box-shadow: var(--box-shadow);
}

.contact .icons-container .icons i{
    height: 6rem;
    width: 6rem;
    line-height: 6rem;
    font-size: 2.5rem;
    color:var(--main-color);
    background: var(--bg);
    border-radius: 50%;
}

.contact .icons-container .icons h3{
    color:var(--black);
    padding: 1rem 0;
    font-size: 2.5rem;
}

.contact .icons-container .icons p{
    color:var(--light-color);
    line-height: 1.8;
    font-size: 1.5rem;
}

.contact .row{
    margin-top: 2rem;
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem;
}

.contact .row .map{
    flex:1 1 45rem;
    width: 100%;
    padding:2rem;
    border:var(--border);
    box-shadow: var(--box-shadow);
    border-radius: .5rem;
}

.contact .row form{
    flex:1 1 45rem;
    padding:2rem;
    border:var(--border);
    box-shadow: var(--box-shadow);
    border-radius: .5rem;
}

.contact .row form .box{
    margin:.7rem 0;
    padding: 1rem;
    font-size: 1.6rem;
    color:var(--black);
    border-radius: .5rem;
    border:var(--border);
    background: #f7f7f7;
    text-transform: none;
    width: 100%;
}

.contact .row form .box:focus{
    background:var(--bg);
}

.contact .row form textarea{
    height: 20rem;
    resize: none;
}

.contact .row form .btn:hover{
    background: var(--black);
}

.footer{
    margin-top: 1rem;
    background: var(--bg);
    padding-bottom: 9rem;
}

.footer .box-container{
    display:grid;
    grid-template-columns: repeat(auto-fit, minmax(23rem, 1fr));
    gap:1.5rem;
}

.footer .box-container .box h3{
    font-size: 2.5rem;
    padding:1rem 0;
    color:var(--black);
}

.footer .box-container .box a{
    display: block;
    font-size: 1.5rem;
    padding:1rem 0;
    color:var(--light-color);
}

.footer .box-container .box a i{
    padding-right: .5rem;
    color:var(--main-color);
}

.footer .box-container .box a:hover i{
    padding-right: 2rem;
}

.footer .credit{
    color: var(--black);
    text-align: center;
    padding:1rem;
    margin-top: 2rem;
    padding-top: 2rem;
    font-size: 2rem;
}

.footer .credit span a{
    color: white;
    background-color: green;
    padding: 5px;
}

.footer .credit span a:hover{
    color: white;
    background-color: indigo;
    padding: 5px;
}














/* media queries  */
@media (max-width:991px){

    html{
        font-size: 55%;
    }

    .header{
        padding:2rem;
    }

    section{
        padding:2rem;
    }

}

@media (max-width:768px){

    #menu-btn{
        display: initial;
    }

    .header .navbar{
        position: absolute;
        top:115%; right: 2rem;
        background:#fff;
        box-shadow: var(--box-shadow);
        border:var(--border);
        border-radius: .5rem;
        width: 30rem;
        transform: scale(0);
        transform-origin: top right;
        opacity: 0;
    }

    .header .navbar.active{        
        transform: scale(1);
        opacity: 1;
    }

    .header .navbar a{
        font-size: 2rem;
        display: block;
        padding:1rem;
        margin: 1rem;
        border-radius: .5rem;
    }

    .header .navbar a:hover{
        background: var(--bg);
    }

    .home .content{
        text-align: center;
    }

}

@media (max-width:450px){

    html{
        font-size: 50%;
    }

}
</style>

<script>let menu = document.querySelector('#menu-btn');
let navbar = document.querySelector('.navbar');

menu.onclick = () =>{
    menu.classList.toggle('fa-times');
    navbar.classList.toggle('active');
} 

window.onscroll = () =>{
    menu.classList.remove('fa-times');
    navbar.classList.remove('active');
} </script>