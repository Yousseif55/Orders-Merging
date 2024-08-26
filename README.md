# Orders Merging

## Description

**Orders Merging** is a WordPress plugin designed to streamline the management of WooCommerce orders by allowing you to merge multiple orders into a single order. The plugin supports merging unlimited orders into the most recent one, including all product items, fees, and extra fields. This updated version includes HPOS (High-Performance Order Storage) compatibility and improved merging functionality.

### Features
- **Bulk Merge Orders:** Merge multiple orders into the most recent one with a single action.
- **Product Items:** Combine products from all orders, updating quantities and prices as necessary.
- **Fees:** Merge fees from all orders into the most recent one.
- **Shipping Meta Data:** Merge shipping meta data with a creative separator.
- **Order Notes:** Automatically add notes to track the merging process.
- **HPOS Compatibility:** Works with High-Performance Order Storage.


## Usage

1. **Merge Orders:**
   - Go to `WooCommerce` > `Orders`.
   - Select the orders you want to merge.
   - Choose `Merge Orders` from the bulk actions dropdown menu and click `Apply`.
   - The plugin will merge the selected orders into the most recent one, including all products, fees, and shipping meta data.

2. **Order Notes:**
   - After merging, notes will be added to both the merged and the merged-into orders to indicate the merging process.

3. **Success Notification:**
   - After a successful merge, a success message will be displayed at the top of the orders page.

## Frequently Asked Questions (FAQ)

### How does the plugin determine the most recent order?
The plugin considers the first selected order as the most recent one for merging purposes. All other selected orders are merged into this one.

### What happens to the old orders after merging?
The old orders are moved to the trash after the merge process. You can permanently delete them from the trash if needed.

### Can I merge orders with different statuses?
The plugin merges orders regardless of their status. However, it's advisable to merge orders with similar statuses for consistency.

### Is there a way to undo a merge?
Currently, the plugin does not support undoing a merge. Ensure you review the orders carefully before merging.

## License

This plugin is licensed under the **GNU General Public License v3.0**. See [LICENSE](LICENSE) for more details.

## Notes

- Ensure compatibility with your WooCommerce setup and test the plugin in a staging environment before deploying it on a live site.
- The plugin is designed for use with WooCommerce and may require customization for specific needs.

## Author

**Yousseif Ahmed**

For more information or support, please contact the author or refer to the plugin documentation.
