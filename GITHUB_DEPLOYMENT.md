# GitHub Actions FTP Deployment Setup

This document explains how to deploy the Electricks Help site to help.electricks.info using GitHub Actions.

## Overview

The site automatically deploys to help.electricks.info whenever code is pushed to the `main` branch. The deployment is handled by GitHub Actions using FTP.

## GitHub Secrets Configuration

You need to configure the following secrets in your GitHub repository:

1. Go to your repository on GitHub
2. Click Settings → Secrets and variables → Actions
3. Add the following repository secrets:

| Secret Name | Description | Example Value |
|------------|-------------|---------------|
| `FTP_SERVER` | FTP server hostname | `ftp.yourdomain.com` |
| `FTP_USERNAME` | FTP username | `your-ftp-username` |
| `FTP_PASSWORD` | FTP password | `your-ftp-password` |
| `FTP_SERVER_DIR_HELP` | Target directory on FTP server | `/public_html/help/` or `/help.electricks.info/` |

## Workflow Details

The deployment workflow (`.github/workflows/deploy.yml`) performs the following steps:

1. **Code Checkout** - Checks out the latest code from the main branch
2. **PHP Setup** - Installs PHP 8.2 with required extensions
3. **PHP Validation** - Validates syntax of all PHP files
4. **File Check** - Verifies all required files are present
5. **Directory Check** - Validates the directory structure
6. **Deployment Info** - Displays deployment metadata
7. **FTP Deploy** - Uploads files to the FTP server
8. **Status Report** - Reports success or failure

## Excluded Files

The following files and directories are NOT deployed to the server:

- `.git*` files and directories
- `.github/` directory
- `node_modules/`
- Development documentation (README, DEPLOYMENT, etc.)
- Test files and logs
- Configuration backups
- Scripts directory
- `.DS_Store` and editor config files

## Manual Deployment

You can manually trigger a deployment:

1. Go to the Actions tab in your GitHub repository
2. Select "Deploy to help.electricks.info" workflow
3. Click "Run workflow"
4. Select the branch (usually `main`)
5. Click "Run workflow"

## Deployment Triggers

The workflow automatically runs when:
- Code is pushed to the `main` branch
- A pull request is merged into `main`
- Manually triggered via the Actions tab

## Monitoring Deployments

To monitor deployment status:

1. Go to the Actions tab in your GitHub repository
2. Click on the latest workflow run
3. View the logs for each step
4. Check for success or failure messages

## Troubleshooting

### Deployment Fails on PHP Validation
- Check PHP syntax errors in the modified files
- Run `php -l filename.php` locally to test

### Missing Files Error
- Ensure all required files exist in the repository
- Check the "Check Required Files" step for which files are missing

### FTP Connection Issues
- Verify FTP credentials in GitHub Secrets
- Check that the FTP server is accessible
- Verify the server directory path is correct

### Files Not Updating
- Check the exclude list in deploy.yml
- Verify files aren't being excluded accidentally
- Clear any server-side caching

## First-Time Setup Checklist

- [ ] Create GitHub repository for the help site
- [ ] Add FTP secrets to GitHub repository settings
- [ ] Verify `.github/workflows/deploy.yml` is in the repository
- [ ] Test deployment by pushing to main branch
- [ ] Verify site loads at https://help.electricks.info
- [ ] Check that navigation and content display correctly

## Security Notes

- Never commit FTP credentials to the repository
- Always use GitHub Secrets for sensitive information
- Keep FTP passwords secure and rotate them regularly
- Use FTPS (FTP over SSL/TLS) if available

## Related Files

- `.github/workflows/deploy.yml` - GitHub Actions workflow configuration
- `.htaccess` - Apache configuration for URL rewriting
- `config.php` - Site configuration
