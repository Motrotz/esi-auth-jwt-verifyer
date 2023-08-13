# Eve Online ESI JWT Authentication helper
This helper replaces the old `/oauth/verify` endpoint. Just install it on your server and call it instead of the old endpoint.

## Why do i need this?
Once upon a time there was an easy to use API. You can still find some old examples [here](https://developers.eveonline.com/blog/article/sso-to-authenticated-calls). But then CCP decided to change the authentication to a more secure one. This is where the JWT authentication comes in. You can read more about the changes [here](https://developers.eveonline.com/blog/article/sso-endpoint-deprecations-2). The problem is, that the old `/oauth/verify` endpoint has been completely removed with the new authentication method. This helper is a workaround for this problem. It replaces the old endpoint and returns the same data as the old endpoint. This way you can use the new authentication with minimal changes to your code.

## ++ WARNING: This helper is work in progress. Use at your own risk. ++
This project was born because i needed a working solution for my own projects. I tried to set up [Skylizer](https://github.com/chrRtg/eve-skylizer) but the SSO implementation was broken. So i decided to fix it. This is all still work in progress, but I decided to make it public anyways.Please look at this list to see what works and what doesn't. If you want to help, feel free to open a pull request.
- [x] Verify JWT token signature
- [ ] Verify JWT token expiration, issuer and audience
- [ ] convert data to old format
- [ ] option to chose between old and new format
- [ ] error handling
- [ ] tests
- [ ] documentation

## Setup

1. Clone this repository
2. Run `composer install`
3. Configure your webserver to point to the `public` folder

## Usage
If you want to use this helper, you need to retrieve a JWT token first. You can do this by using a OAuth2 library like [league/oauth2-client](https://github.com/thephpleague/oauth2-client) and a oauth2 provider like [EvELabs/oauth2-eveonline](https://github.com/EvELabs/oauth2-eveonline). Read the Eve documentation and the documentation of those libraries for more information. To get the identity provider to work, you need the /oauth/verify endpoint. This is where this helper comes in.

1. Install this helper on your server. Use a subdomain like `token.example.com`.
2. Configure your oauth2 provider to use the new endpoint. The endpoint is `https://token.example.com/`. You need to modify the provider to use the new endpoint. For example, if you use the EvELabs provider, you need to change the `getResourceOwnerDetailsUrl` to return `https://token.example.com/`.
4. enjoy a working ESI JWT authentication

## Future plans
I'm planning to add more features to this helper. If you have any ideas, feel free to open an issue or a pull request. I'm also thinking about addinga docker image to make it easier to deploy this helper. Maybe I'll create a new oauth2 provider that either uses this helper, or works without the need for a helper at all. But this is still in the future. I'd like to get this helper working with the existing providers first.

## Credits
This project wouldn't exist without the following projects:
- [eve-skylizer](https://github.com/chrRtg/eve-skylizer) - Thanks for the inpiration 
- [league/oauth2-client](https://github.com/thephpleague/oauth2-client) - Thanks for the great OAuth2 library
- [EvELabs/oauth2-eveonline](https://github.com/EvELabs/oauth2-eveonline) - Thanks for the OAuth2 provider I've based my work on
- [jose-php](https://github.com/nov/jose-php/) - Thanks for the JWT library