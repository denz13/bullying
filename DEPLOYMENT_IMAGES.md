# Image Deployment Instructions for Production

## Issue
Images are returning 404 errors on production server (Hostinger) but work fine locally.

## Root Cause
The images are not uploaded to the production server's `public/img` folder.

## Solution

### Step 1: Upload Images to Production Server

**Option A: Via FTP/SFTP**
1. Connect to your Hostinger server via FTP/SFTP (FileZilla, WinSCP, etc.)
2. Navigate to your Laravel project root
3. Go to: `public/img/` folder
4. Upload ALL images from your local `public/img/` folder (or `resources/img/` folder)

**Option B: Via Hostinger File Manager**
1. Login to Hostinger hPanel
2. Go to File Manager
3. Navigate to: `public_html/public/img/` (or `domains/guidanceoffice.icsni-ict.com/public_html/public/img/`)
4. Upload all image files

**Option C: Via Git (if using version control)**
1. Make sure `public/img/` folder is NOT in `.gitignore`
2. Commit and push the images
3. Pull on production server

### Step 2: Verify Image Paths
After uploading, test if images are accessible:
- `https://guidanceoffice.icsni-ict.com/img/484248712_1132362428690563_3086813121712650172_n.jpg`
- Should return the image, not 404

### Step 3: Check File Permissions
On production server, set proper permissions:
```bash
chmod 755 public/img
chmod 644 public/img/*.jpg
```

### Step 4: Verify .env Configuration
Make sure your `.env` file on production has:
```env
APP_URL=https://guidanceoffice.icsni-ict.com
```

### Step 5: Clear Cache (if needed)
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

## Quick Verification
1. SSH into production server
2. Check if folder exists: `ls -la public/img/`
3. Check if files are there: `ls -la public/img/*.jpg`
4. Check file permissions: `stat public/img/`

## Common Issues

### Issue: Images still 404 after upload
**Solution:** 
- Check if `public/img` folder exists on production
- Verify file names match exactly (case-sensitive on Linux)
- Check `.htaccess` is not blocking image access
- Verify APP_URL in .env is correct

### Issue: Different folder structure on Hostinger
Some Hostinger setups use `public_html` as the document root. In this case:
- Images should be in: `public_html/public/img/`
- Or create symlink if Laravel is in subdirectory

## Files to Upload
Upload these 9 images to `public/img/` on production:
- 344328784_253750887103220_1974030104454798749_n.jpg
- 411727676_835998658326943_6625844800079170854_n.jpg
- 480869815_1122195819707224_4126403147328611230_n.jpg
- 484248712_1132362428690563_3086813121712650172_n.jpg
- 485086483_1133980995195373_3088813064464928378_n.jpg
- 485142595_1133988011861338_7400880015275016593_n.jpg
- 485750791_1137172758209530_2901125920906621887_n.jpg
- 488657717_1149277773665695_1587228246426937413_n.jpg
- 80006502_3358051770934694_5159145884532867072_n.jpg

