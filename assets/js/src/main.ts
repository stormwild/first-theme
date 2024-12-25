/**
 * Main theme JavaScript file
 */

// Import modules
import { initNavigation } from './modules/navigation'
import { setupTheme } from './modules/setup'

document.addEventListener('DOMContentLoaded', () => {
  // Initialize theme functionality
  setupTheme()
  initNavigation()
})

// Handle WordPress admin bar
if (document.body.classList.contains('admin-bar')) {
  const siteHeader = document.querySelector('.site-header')
  if (siteHeader) {
    siteHeader.classList.add('has-admin-bar')
  }
}
