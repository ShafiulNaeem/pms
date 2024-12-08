# Product Management Sysytem

## Instruction
- Install or update all required dependencies using Composer:
      ```
      composer update
      ```
- Run Database Migrations: ``` php artisan migrate ```
- Seed the Database: ``` php artisan db:seed ```
- Configure Stripe
   ```
    STRIPE_KEY=your_stripe_key
    STRIPE_SECRET=your_stripe_secret
   ```
- ### Testing Instructions:
    - To test all features, reset the database and run the tests: 
        ```
            php artisan migrate:fresh
            php artisan db:seed
            php artisan test
        ```
    - or Run Specific Test ``` php artisan test --filter=your_test_function```


