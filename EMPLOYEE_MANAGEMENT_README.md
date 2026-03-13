# Leave Go - Employee Management System

A modern, iOS-inspired employee management system built with Laravel and featuring Apple-style design principles.

## Features

### 🔐 Authentication System
- **Email & Password Validation**: Secure login with proper validation
- **Error Handling**: Clear error messages for incorrect credentials
- **Session Management**: Secure session handling with remember me functionality
- **Access Control**: Role-based access control for admin and regular users

### 👥 Employee Management
- **Create Employee Accounts**: Add new employees with detailed information
- **Edit Employee Information**: Update employee details, position, salary, etc.
- **Deactivate/Activate Accounts**: Toggle employee status without deletion
- **Delete Accounts**: Permanent removal with safety checks
- **Duplicate Prevention**: Email uniqueness validation

### 🎨 Apple-Inspired Design
- **iOS-style Interface**: Clean, minimalist design following Apple's design language
- **Smooth Animations**: Subtle transitions and micro-interactions
- **Premium Feel**: Glass morphism effects, proper spacing, and typography
- **Responsive Design**: Works seamlessly on desktop and mobile devices
- **Accessibility**: Proper contrast ratios and keyboard navigation

### 🔔 Notifications
- **Success Messages**: Confirmation for successful actions
- **Error Notifications**: Clear error feedback
- **Auto-dismiss**: Notifications automatically disappear after 5 seconds
- **Manual Close**: Users can close notifications manually

## Quick Start

### 1. Default Admin Account
```
Email: admin@leavego.com
Password: admin123
```

### 2. Access the System
1. Open your browser and navigate to: `http://127.0.0.1:8000`
2. Login with the admin credentials above
3. You'll be redirected to the admin dashboard

### 3. Managing Employees

#### Adding New Employees
1. Click "Add Employee" in the navigation
2. Fill in the required information:
   - Full Name (required)
   - Email Address (required, must be unique)
   - Password (required, minimum 8 characters)
   - Confirm Password
   - Position (optional)
   - Office (optional)
   - Salary (optional)
3. Click "Create Employee Account"

#### Editing Employees
1. Go to Employees page
2. Click the edit icon (✏️) next to the employee
3. Update the information as needed
4. Password is optional when editing - leave blank to keep current password
5. Click "Update Employee"

#### Deactivating/Activating Employees
1. Find the employee in the list
2. Click the pause icon (⏸️) to deactivate
3. Click the play icon (▶️) to activate
4. Status badge shows current state

#### Deleting Employees
1. Click the trash icon (🗑️) next to the employee
2. Confirm the deletion in the popup
3. Note: You cannot delete admin accounts or your own account

## Access Control

### Admin Users
- Can create, edit, and delete employee accounts
- Can access admin dashboard
- Can manage all employee accounts
- Cannot delete their own account

### Regular Users
- Can only access their own profile
- Cannot manage other employees
- Can submit leave requests

## Security Features

### Password Security
- Minimum 8 characters requirement
- Password strength indicator during creation
- Hashed password storage
- Password confirmation for account creation

### Access Control
- Middleware-based protection
- Role-based permissions
- Session security
- CSRF protection on all forms

### Data Validation
- Email format validation
- Unique email enforcement
- Required field validation
- Proper error messaging

## Design Principles

### iOS-Inspired Elements
- **Typography**: San Francisco font stack
- **Colors**: Apple system colors and gradients
- **Spacing**: Consistent 8-point grid system
- **Rounded Corners**: 12-20px radius for cards and buttons
- **Shadows**: Subtle, layered shadows for depth

### User Experience
- **Intuitive Navigation**: Clear menu structure
- **Visual Feedback**: Hover states and transitions
- **Error Prevention**: Clear validation and guidance
- **Consistency**: Unified design language throughout

## Technical Stack

- **Backend**: Laravel 12
- **Frontend**: Blade templates with Tailwind CSS
- **Database**: SQLite (development ready)
- **Authentication**: Laravel's built-in auth system
- **Validation**: Laravel's validation engine
- **Styling**: Custom CSS with Apple design principles

## Routes Overview

### Authentication
- `GET /` - Login page
- `POST /login` - Login submission
- `POST /logout` - Logout

### Employee Management
- `GET /employees` - Employee list
- `GET /employees/create` - Create employee form
- `POST /employees` - Store new employee
- `GET /employees/{id}/edit` - Edit employee form
- `PUT /employees/{id}` - Update employee
- `DELETE /employees/{id}` - Delete employee
- `POST /employees/{id}/toggle-status` - Activate/deactivate

### Dashboard
- `GET /dashboard` - Main dashboard (redirects based on role)

## Development Notes

### Adding New Features
- Follow the existing naming conventions
- Use the established design patterns
- Include proper validation and error handling
- Add notifications for user feedback

### Customization
- Colors and spacing can be adjusted in the CSS
- New validation rules can be added to controllers
- Additional fields can be added to the User model

## Troubleshooting

### Common Issues
1. **Login not working**: Ensure the database is seeded with the admin user
2. **Styles not loading**: Run `npm run dev` to compile assets
3. **Permission errors**: Check that the user has the correct admin status

### Database Reset
```bash
php artisan migrate:fresh --seed
```

This will reset the database and create the default admin account.

---

**Leave Go** - Modern employee management with Apple-inspired design 🍎
