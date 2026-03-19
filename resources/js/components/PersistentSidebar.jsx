import React from 'react';
import './PersistentSidebar.css';

/**
 * PersistentSidebar Component
 * 
 * Provides a clean, professional sidebar for the LeaveGo management system.
 * Designed to remain visible across different dashboard views.
 */
const PersistentSidebar = ({ activeTab, onTabChange }) => {
  const navItems = [
    { id: 'pending', label: 'Pending Requests', icon: '📥' },
    { id: 'important', label: 'Important', icon: '⭐' },
    { id: 'approved', label: 'Approved Forms', icon: '✅' },
    { id: 'account-management', label: 'Account Management', icon: '👤' },
    { id: 'monthly-summary', label: 'Monthly Summary', icon: '📊' },
  ];

  return (
    <aside className="lg-sidebar">
      <div className="lg-sidebar-header">
        <div className="lg-sidebar-logo">
          <svg width="24" height="24" viewBox="0 0 32 32" fill="none">
            <rect width="32" height="32" rx="6" fill="#007AFF"/>
            <path d="M16 8L24 16L16 24L8 16L16 8Z" fill="white"/>
          </svg>
          <span>LeaveGo</span>
        </div>
        <div className="lg-sidebar-subtitle">Personnel Management</div>
      </div>

      <nav className="lg-sidebar-nav">
        <div className="lg-nav-section-title">Applications</div>
        {navItems.slice(0, 3).map((item) => (
          <button
            key={item.id}
            className={`lg-nav-item ${activeTab === item.id ? 'active' : ''}`}
            onClick={() => onTabChange(item.id)}
          >
            <div className="lg-nav-icon">{item.icon}</div>
            <span className="lg-nav-label">{item.label}</span>
          </button>
        ))}

        <div className="lg-nav-section-title" style={{ marginTop: '24px' }}>System</div>
        {navItems.slice(3).map((item) => (
          <button
            key={item.id}
            className={`lg-nav-item ${activeTab === item.id ? 'active' : ''}`}
            onClick={() => onTabChange(item.id)}
          >
            <div className="lg-nav-icon">{item.icon}</div>
            <span className="lg-nav-label">{item.label}</span>
          </button>
        ))}
      </nav>

      <div className="lg-sidebar-footer">
        <div className="lg-user-info">
          <div className="lg-user-avatar">JD</div>
          <div className="lg-user-details">
            <div className="lg-user-name">Admin User</div>
            <div className="lg-user-role">Super Administrator</div>
          </div>
        </div>
      </div>
    </aside>
  );
};

export default PersistentSidebar;
