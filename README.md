# Developer Forms

Easy ass AJAX contact forms. It's like Formkeep, but free!

[![Deploy](https://www.herokucdn.com/deploy/button.svg)](https://heroku.com/deploy?template=https://github.com/alright-studio/developer-forms)


## Required Environment Variables

- `MAILGUN_API_KEY`
- `MAILGUN_DOMAIN`

## How To Use

1. Submit a JSON `POST` request to `<< yourdomain >>/submit` with the following fields:

```js
{
	from: 'Full Name',
	to: 'inbox@example.com',
	subject: 'Hello World',
	html: '<html><body>hello world</body></html>',
	text: 'hello world'
}
```

2. Done, the email is sent!