<header></header>
    <img src="views/img/logo.png" alt="MoviePass" class="logo">
    <p class="title">MoviePass</p>
    <div id="scroller">
        <div class="container">
            <h1>Welcome</h1>
            <form action="HomePage/login" method="POST">
                <input type="text" name="email" placeholder="Type your email" required>
                <input type="password" name="password" placeholder="Type your password" required>
                <button type="submit" class="submit">Log In</button> <p class="or">or</p>
                <button type="button" id="register">Sign Up</button>
            </form>
        </div>

        <div id="sign-up">
            <form action="Register\register" method="POST">
                <input type="text" name="firstName" placeholder="Type your first name" required>
                <input type="text" name="surName" placeholder="Type your surname" required>
                <input type="number" name="dni" placeholder="Type your dni" required>
                <input type="email" name="email" placeholder="Type your email" required>
                <input type="password" name="pass" placeholder="Type your password" required>
                <button type="submit" class="submit">Sign Up</button> <p class="or">or</p>
                <button type="button" id="back">Back</button>
            </form>
        </div>
    </div>
<footer></footer>
</body>