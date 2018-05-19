# Developer Forms

Easy ass AJAX contact forms. It's like Formkeep, but free!

## Requirements

- Mailgun Environment Variables
	- `MAILGUN_API_KEY`
	- `MAILGUN_DOMAIN`

## How To Use

1. Submit a JSON `POST` request to [https://developer-forms.herokuapp.com/submit](https://developer-forms.herokuapp.com/submit) with the following fields:

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