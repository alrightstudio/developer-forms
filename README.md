# Developer Forms

Easy ass AJAX contact forms. It's like Formkeep, but free!

## How To Use

1. Submit a `POST` request to [https://developer-forms.herokuapp.com/submit](https://developer-forms.herokuapp.com/submit) with the following fields:

```js
{
	name: 'Full Name', // Sender's name
	email: 'sender@example.com', // Sender's email address
	recipient: 'inbox@example.com', // Where the email should go
	message: '<html><body>hello world</body></html>',
}
```

2. Done, the email is sent!