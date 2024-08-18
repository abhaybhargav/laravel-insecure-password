# Laravel Insecure Password Storage Demo

This application demonstrates the difference between secure and insecure password storage methods in a Laravel application. It is designed for educational purposes to show developers the importance of using secure password hashing techniques.

## WARNING

**This application intentionally includes insecure practices for educational purposes. DO NOT use this code in a production environment.**

**IMPORTANT: Returning password hashes in API responses, as done in this demo, is a security risk and should never be done in real-world applications. This is only for demonstration purposes.**

## Setup and Running the Application

1. Clone this repository
2. Navigate to the project directory
3. Build and run the Docker container:
   ```
   docker build -t laravel-insecure-password .
   docker run -p 8880:8880 laravel-insecure-password
   ```
4. The application will be available at `http://localhost:8880`

## Interacting with the Application

The application provides two API endpoints:

1. `/api/signup` (POST): Register a new user
2. `/api/users` (GET): List all registered users

### Registering a User

Use a tool like cURL or Postman to send a POST request to `http://localhost:8880/api/signup` with the following JSON body:

```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123"
}
```

### Listing Users

Send a GET request to `http://localhost:8880/api/users` to see all registered users and their hashed passwords.

## Secure vs Insecure Modes

The application can operate in two modes: secure and insecure. This is controlled by the `APP_SECURE_MODE` environment variable in the `.env` file.

### Secure Mode (Default)

In secure mode (`APP_SECURE_MODE=true`), the application uses bcrypt to hash passwords. Bcrypt is a strong, slow hashing algorithm that includes a salt and is resistant to rainbow table attacks.

Example of a bcrypt hash:
```
$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi
```

### Insecure Mode

In insecure mode (`APP_SECURE_MODE=false`), the application uses SHA1 to hash passwords. SHA1 is a fast hashing algorithm that is vulnerable to rainbow table attacks and should not be used for password hashing.

Example of a SHA1 hash:
```
5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8
```

## Demonstrating the Vulnerability

1. Set `APP_SECURE_MODE=false` in the `.env` file and restart the application.
2. Register a new user with a common password.
3. Retrieve the user list and copy the SHA1 hash of the password.
4. Visit [CrackStation](https://crackstation.net/) and paste the SHA1 hash.
5. Observe how quickly the password is cracked.

This demonstrates why using fast, unsalted hashing algorithms like SHA1 for password storage is insecure.

## Security Best Practices

In real-world applications:
1. Always use strong, slow hashing algorithms like bcrypt, Argon2, or PBKDF2 for password storage.
2. Never return password hashes in API responses.
3. Implement proper authentication and authorization mechanisms.
4. Use HTTPS for all communications.
5. Follow the principle of least privilege in your application design.

Remember, security is crucial in application development. Always stay informed about best practices and potential vulnerabilities.