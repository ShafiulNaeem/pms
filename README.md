# Product Management Sysytem

## Instruction
- # Update Dependencies: ``` composer update ```
- Run migrate command: ``` php artisan migrate ```
- Run seed command: ``` php artisan db:seed ```
- Setupt Stripe add  variable ``` STRIPE_KEY, STRIPE_SECRET ``` to  ``` .env```.
- # Testing:
    - Test all feature 
        ```
            php artisan migrate:fresh
            php artisan db:seed
            php artisan test
        ```
    - or ``` php artisan test --filter=your_test_function


