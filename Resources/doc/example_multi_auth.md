SSO CAS and Regular Auth
========================

In some case, your app need two auth types. The first one can be a regular auth form, with login and password that match user in your database. And the other, a SSO auth.

Here I show you how-to configure BeSimpleSsoAuthBundle for this case.

First, the firewall :

    # app/config/security.yml
firewalls:

    my_firewall:
        pattern:    ^/
        logout:
            path:   _logout
            target: /
        anonymous: true
        form_login:
            check_path: _login_check
            login_path: _auth_login
        trusted_sso:
            manager: user_sso
            login_action: MyAppBundle:Auth:login 
            logout_action: MyAppBundle:Auth:logout
            always_use_default_target_path: true
            created_users_roles: [ROLE_USER]
            login_path: /cas/login
            check_path: /cas/login_check
            force_login_path: /cas/goto-cas #This URL trigger BeSimpleSsoAuthBundle for redirect the user to SSO login form

Next the MyAppBundle AuthController :

    class AuthController extends Controller
    {
        /**
         * @Route("/login", name="_auth_login")
         * @Route("/login-check", name="_login_check")
         * @Template()
         */
        public function loginAction(Request $request)
        {
            // Regular actions for a Regular Auth
        }

        /**
         * @Route("/logout", name="_logout")
         */
        public function logoutAction()
        {
            return $this->redirect($this->generateUrl("_welcome"));
        }

Finaly the Twig Template :

        <form action="{{ path('_login_check') }}" method="post" role="form">
                <label for="username">Username</label>
                <input class="form-control" type="text" id="username" name="_username" value="{{ last_username }}" />

                <label for="password">Password</label>
                <input class="form-control" type="password" id="password" name="_password" />

            <button type="submit">Se connecter</button>
        </form>

        <a href="{{ url("cas_force_login") }}">Use SSO Auth !</a>
       
