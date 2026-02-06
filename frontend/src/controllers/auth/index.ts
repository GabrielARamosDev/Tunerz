class Auth {

    logout = () => {
        document.getElementById('logout-form').submit();
    };

}

const auth = new Auth();

export default auth;
