# Railway Deployment Guide

## 🚀 Deploy to Railway in 5 Minutes

### Prerequisites
- GitHub account
- Railway account (sign up at https://railway.app)
- Your code pushed to GitHub

---

## Step-by-Step Deployment

### 1. Push Your Code to GitHub

```bash
# Initialize git (if not already done)
git init
git add .
git commit -m "Initial commit - Task Management System"

# Create a new repository on GitHub, then:
git remote add origin https://github.com/Saransh-Jainbu/task-management-system.git
git branch -M main
git push -u origin main
```

### 2. Deploy on Railway

1. **Go to Railway**: https://railway.app
2. **Click "Start a New Project"**
3. **Select "Deploy from GitHub repo"**
4. **Choose your repository**: `task-management-system`
5. **Railway will auto-detect Laravel** and start building

### 3. Add MySQL Database

1. In your Railway project, click **"+ New"**
2. Select **"Database" → "MySQL"**
3. Railway will automatically:
   - Create a MySQL database
   - Set environment variables
   - Link it to your app

### 4. Set Environment Variables

Railway auto-sets most variables, but you need to add:

**Click on your service → Variables tab → Add these:**

```env
APP_NAME="Task Manager"
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:YOUR_KEY_HERE
APP_URL=https://your-app.railway.app

# Database (Railway auto-fills these from MySQL service)
# DB_CONNECTION=mysql
# DB_HOST=...
# DB_PORT=...
# DB_DATABASE=...
# DB_USERNAME=...
# DB_PASSWORD=...

SESSION_DRIVER=database
CACHE_DRIVER=database
QUEUE_CONNECTION=database
```

**Generate APP_KEY locally:**
```bash
php artisan key:generate --show
```
Copy the output and paste it as `APP_KEY` value.

### 5. Deploy!

Railway will automatically:
- ✅ Install dependencies (`composer install`)
- ✅ Run migrations (`php artisan migrate --force`) 
- ✅ Start the server
- ✅ Give you a public URL

---

## 🎉 Your App is Live!

Railway will provide a URL like:
```
https://task-management-system-production.up.railway.app
```

Visit it to see your deployed app!

---

## 🔧 Useful Railway Commands

### View Logs
Click on your service → **Deployments** → **View Logs**

### Redeploy
Click **"Deploy"** button or push new commits to GitHub

### Run Artisan Commands
Click **"Shell"** tab and run:
```bash
php artisan migrate
php artisan cache:clear
php artisan config:clear
```

---

## 🐛 Troubleshooting

### "500 Error" after deployment
1. Check logs in Railway dashboard
2. Make sure `APP_KEY` is set
3. Verify MySQL database is connected

### "Database connection failed"
1. Make sure MySQL service is running
2. Check that Railway auto-linked the database
3. Verify environment variables are set

### "Migration failed"
1. Go to Shell tab
2. Run: `php artisan migrate:fresh --force`

---

## 💰 Pricing

- **Free Tier**: $5 credit/month
- **Hobby Plan**: $5/month (recommended)
- Includes: MySQL database + web hosting

---

## 🔄 Auto-Deployment

Every time you push to GitHub:
1. Railway detects the push
2. Runs tests (if configured)
3. Deploys automatically
4. Updates your live site

**No manual deployment needed!** 🎉

---

## 📊 Monitoring

Railway Dashboard shows:
- ✅ CPU/Memory usage
- ✅ Request logs
- ✅ Database metrics
- ✅ Deployment history

---

## Next Steps

1. ✅ Deploy to Railway
2. ✅ Test your live app
3. ✅ Share the URL!
4. Optional: Add custom domain

**Your Task Management System is now live!** 🚀
