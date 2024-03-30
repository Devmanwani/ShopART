<?php
class NavigationMenuProvider {

    private $con, $userLoggedInObj;

    public function __construct($con, $userLoggedInObj) {
        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;
    }
    

    public function create() {
        $menuHtml="";
        if(isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] !== 'admin'){
        $usernameLoggedIn = isset($_SESSION["userLoggedIn"]) ? $_SESSION["userLoggedIn"] : "";
        $menuHtml = $this->createNavItem("Home", "assets/images/icons/home.png", "index.php");
        $menuHtml .= $this->createNavItem("Trending", "assets/images/icons/trending.png", "trending.php");
        $menuHtml .= $this->createNavItem("Liked Artworks", "assets/images/icons/thumb-up.png", "likedVideos.php");
        $menuHtml .= $this->createNavItem("Collectibles", "assets/images/icons/collectibles.png", "collectibles.php");
        $menuHtml .= $this->createNavItem("Gif", "image/gif.png", "gif.php");
        $menuHtml .= $this->createNavItem("Photography", "image/photography.png", "photography.php");}

        if(user::isLoggedIn()) {
            if(isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] == 'admin'){
                $usernameLoggedIn = isset($_SESSION["userLoggedIn"]) ? $_SESSION["userLoggedIn"] : "";
                $menuHtml .= $this->createNavItem("Transactions","assets/images/icons/transactions.png","transaction_template.php?username=$usernameLoggedIn");
                $menuHtml .= $this->createNavItem("Manage Users","assets/images/icons/manage_user.png","adminPanel.php");
                $menuHtml .= $this->createNavItem("Log Out", "assets/images/icons/logout.png", "logout.php");
            }
            if(isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] !== 'admin'){
            $usernameLoggedIn = isset($_SESSION["userLoggedIn"]) ? $_SESSION["userLoggedIn"] : "";
            $menuHtml .= $this->createNavItem("Transactions","assets/images/icons/transactions.png","transaction_template.php?username=$usernameLoggedIn");
            $menuHtml .= $this->createNavItem("Settings", "assets/images/icons/settings.png", "settings.php");
            $menuHtml .= $this->createNavItem("Log Out", "assets/images/icons/logout.png", "logout.php");}
            

        }

        return "<div class='navigationItems'>
                    $menuHtml
                </div>";
    }

    private function createNavItem($text, $icon, $link) {
        return "<div class='navigationItem'>
                    <a href='$link'>
                        <img src='$icon'>
                        <span>$text</span>
                    </a>
                </div>";
    }

    

}
?>