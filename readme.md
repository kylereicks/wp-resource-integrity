Add integrity and crossorigin attributes to WordPress resources
===============================================================

```php
wp_script_add_data( 'script-handle', 'integrity', 'sha384-sDc5PYnGGjKkmKOlkzS+YesGwz4SwiEm6fhX1vbXuVxeS6sSooIz0V3E7y8Gk2CB' );
wp_script_add_data( 'script-handle', 'crossorigin', 'anonymous' );

wp_style_add_data( 'style-handle', 'integrity', 'sha384-5N3soZvYZ/q8LjWj8vDk5cHod041te75qnL+79nIM6NfuSK5ZJLu5CE6nRu6kefr' );
wp_style_add_data( 'style-handle', 'crossorigin', 'anonymous' );
```
