# Learn Here Free - PHP Version

Complete PHP conversion of the React-based educational video learning platform with identical features and functionality.

## Features

### 🎯 Core Features
- ✅ **Open Access Platform** - No authentication required, completely public access
- ✅ **Hierarchical Content Management** - Batches → Subjects → Videos structure
- ✅ **Video Integration** - YouTube embedding with privacy-enhanced URLs
- ✅ **Admin Dashboard** - Complete content management without login requirements
- ✅ **Multi-Platform Videos** - Support for YouTube, Vimeo, and other platforms
- ✅ **Responsive Design** - Mobile-first design with Tailwind CSS
- ✅ **Database Management** - MySQL/PostgreSQL support with PDO

### 📁 File Structure
```
php-version/
├── index.php              # Homepage with batch listings
├── batch.php              # Batch detail page with subjects
├── subject.php            # Subject page with videos
├── multi-video.php        # Multi-platform videos page
├── admin/
│   └── index.php          # Admin dashboard
├── config/
│   └── database.php       # Database configuration
├── includes/
│   └── functions.php      # Common PHP functions
└── README.md              # This file
```

## Installation & Setup

### Requirements
- PHP 7.4 or higher
- MySQL 5.7+ or PostgreSQL 10+
- Web server (Apache/Nginx)

### Quick Setup

1. **Database Configuration**
   ```php
   // Edit config/database.php
   $host = 'localhost';
   $dbname = 'learn_here_free';
   $username = 'your_username';
   $password = 'your_password';
   ```

2. **Upload Files**
   - Upload all PHP files to your web server
   - Ensure proper file permissions

3. **Database Auto-Setup**
   - Tables are created automatically on first visit
   - Sample data is inserted if database is empty

4. **Access Website**
   - Visit `index.php` to see the homepage
   - Visit `admin/` for content management

## Database Schema

### Tables Created Automatically:
- **batches** - Learning batch categories
- **courses** - Course groupings (optional)
- **subjects** - Subject categories within batches
- **videos** - Individual video content
- **multi_platform_videos** - Videos from various platforms

## Feature Comparison with React Version

| Feature | React Version | PHP Version | Status |
|---------|---------------|-------------|---------|
| Homepage with Batches | ✅ | ✅ | Complete |
| Batch Details | ✅ | ✅ | Complete |
| Subject Videos | ✅ | ✅ | Complete |
| Admin Dashboard | ✅ | ✅ | Complete |
| Multi-Platform Videos | ✅ | ✅ | Complete |
| Video Protection System | ✅ | ⚠️ | Basic (can be enhanced) |
| Ad Monetization | ✅ | ⚠️ | Can be added |
| Real-time Updates | ✅ | ❌ | Page refresh required |
| Modern UI Components | ✅ | ✅ | Tailwind CSS |

## Admin Features

### Content Management
- **Create/Delete Batches** - Add new learning categories
- **Create Subjects** - Add subjects within batches
- **Create Videos** - Add YouTube videos with auto-ID extraction
- **Multi-Platform Videos** - Support for YouTube, Vimeo, etc.

### Access Control
- **Open Access** - No authentication required (same as React version)
- **Public Admin Panel** - Anyone can manage content
- **Safe Operations** - Soft deletes to preserve data

## Sample Data

The system automatically creates sample data including:
- **MBBS Foundation** batch with Anatomy & Physiology subjects
- **Engineering Basics** batch with Mathematics
- **Science Fundamentals** batch with Physics
- Sample videos with YouTube integration

## Customization

### Adding New Platforms
Edit `functions.php` to add new video platform support:

```php
function createMultiPlatformVideo($title, $platform, $videoId, $videoUrl, ...) {
    // Add custom platform logic here
}
```

### Styling
- Uses Tailwind CSS (CDN version)
- Font Awesome icons
- Responsive grid layouts
- Hover effects and transitions

### Database Connection
Supports both MySQL and PostgreSQL:
- Edit `config/database.php` for custom database settings
- Uses PDO for database abstraction
- Automatic table creation and sample data insertion

## Security Features

- **Input Sanitization** - All user inputs are sanitized
- **Prepared Statements** - SQL injection protection
- **XSS Protection** - HTML entity encoding
- **Safe File Handling** - Secure file operations

## Performance Features

- **Efficient Queries** - Optimized database queries
- **CDN Assets** - Tailwind CSS and Font Awesome from CDN
- **Responsive Images** - YouTube thumbnail optimization
- **Minimal JavaScript** - Server-side rendering for speed

## Deployment

### LAMP/LEMP Stack
1. Upload files to web directory
2. Configure database credentials
3. Ensure PHP extensions: PDO, PDO_MySQL/PDO_PGSQL
4. Set proper file permissions

### Shared Hosting
- Works on most shared hosting providers
- No special server requirements
- Standard PHP hosting is sufficient

### VPS/Dedicated Server
- Full control over configuration
- Can optimize for performance
- Support for custom domains

## Migration from React Version

The PHP version maintains the same:
- Database structure (adapted for SQL)
- URL structure (`/batch.php?id=...`)
- Feature set and functionality
- Admin capabilities
- Content organization

## Support & Maintenance

### Adding Content
1. Visit `/admin/` 
2. Use the tabs: Batches, Subjects, Videos
3. Fill forms and submit
4. Content appears immediately

### Backup & Restore
- Database: Standard SQL backup/restore
- Files: Simple file copy
- No complex build processes

## Future Enhancements

Possible additions to match React version completely:
- Advanced video protection overlays
- Ad monetization integration  
- Real-time notifications
- Advanced analytics
- User progress tracking
- Course certificates

---

**This PHP version provides identical functionality to the React version while offering the simplicity and compatibility of traditional PHP hosting.**