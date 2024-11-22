# WooCommerce Category Manager

## Overview
This WordPress plugin provides automated category management for WooCommerce products. It helps store administrators efficiently organize and maintain product categories based on custom rules and conditions.

## Features
- Automatic category assignment based on product attributes
- Bulk category updates
- Category rules management
- Category hierarchy maintenance
- Category migration tools
- Scheduled category updates

## Installation

1. Upload the plugin files to `/wp-content/plugins/woocommerce-category-manager`
2. Activate the plugin through the WordPress plugins screen
3. Configure the plugin settings under WooCommerce > Category Manager

## Usage

### Basic Configuration
1. Navigate to WooCommerce > Category Manager
2. Set up your category rules
3. Apply rules to existing products
4. Enable automatic categorization for new products

### Category Rules
Rules can be created based on:
- Product attributes
- Price ranges
- Stock status
- Product tags
- Custom fields

### Example Rule Configuration
```php
// Example rule structure
{
    'rule_name': 'Summer Collection',
    'conditions': [
        'tag' => 'summer',
        'price_range' => [0, 99.99],
        'attributes' => ['season' => 'summer']
    ],
    'target_category': 'summer-wear'
}
```

## Admin Interface

### Main Settings
- Enable/disable automatic categorization
- Set update frequency
- Configure notification preferences
- Manage rule priorities

### Bulk Operations
- Mass category updates
- Category rule testing
- Category cleanup
- Orphaned product detection

## Technical Details

### Hooks and Filters

#### Available Actions
```php
do_action('wcm_before_category_update', $product_id, $new_categories);
do_action('wcm_after_category_update', $product_id, $old_categories, $new_categories);
do_action('wcm_rule_created', $rule_id);
```

#### Available Filters
```php
apply_filters('wcm_category_rules', $rules);
apply_filters('wcm_category_conditions', $conditions, $product_id);
```

### Database Tables
- `wp_wcm_rules` - Stores category rules
- `wp_wcm_rule_conditions` - Stores rule conditions
- `wp_wcm_log` - Stores category update history

## Troubleshooting

### Common Issues
1. Categories not updating
   - Check rule configurations
   - Verify WooCommerce hooks are running
   - Check PHP memory limits

2. Performance issues
   - Optimize rule complexity
   - Enable caching
   - Schedule updates during off-peak hours

### Debug Mode
Enable debug mode by adding to wp-config.php:
```php
define('WCM_DEBUG', true);
```

## Best Practices
- Regular rule maintenance
- Backup before bulk updates
- Test rules on staging environment
- Monitor category depth
- Regular log cleanup

## Requirements
- WordPress 5.0+
- WooCommerce 3.0+
- PHP 7.4+
- MySQL 5.6+

## Support
- Documentation: [Link to docs]
- Support tickets: [Link to support]
- Bug reports: [Link to GitHub issues]

## Changelog

### 1.0.0 (2024-03-20)
- Initial release
- Basic category management
- Rule system implementation

### 1.0.1 (2024-03-21)
- Bug fixes
- Performance improvements
- Added bulk operations

## License
GPL v2 or later

## Credits
Developed by [Your Name/Company]