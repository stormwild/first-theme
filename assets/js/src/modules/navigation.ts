/**
 * Navigation functionality
 */

export function initNavigation(): void {
  const menuToggle = document.querySelector('.menu-toggle')
  const mainNav = document.querySelector('.main-navigation')

  if (!menuToggle || !mainNav) return

  // Handle mobile menu toggle
  menuToggle.addEventListener('click', (e: Event) => {
    e.preventDefault()
    const button = e.currentTarget as HTMLButtonElement
    const isExpanded = button.getAttribute('aria-expanded') === 'true'

    button.setAttribute('aria-expanded', (!isExpanded).toString())
    mainNav.classList.toggle('is-active')

    // Update button text for accessibility
    const span = button.querySelector('span')
    if (span) {
      span.textContent = isExpanded ? 'Open Menu' : 'Close Menu'
    }
  })

  // Handle sub-menu toggles
  const subMenuToggles = document.querySelectorAll('.sub-menu-toggle')
  subMenuToggles.forEach((toggle) => {
    toggle.addEventListener('click', (e: Event) => {
      e.preventDefault()
      const button = e.currentTarget as HTMLButtonElement
      const isExpanded = button.getAttribute('aria-expanded') === 'true'
      const subMenu = button.nextElementSibling as HTMLElement

      button.setAttribute('aria-expanded', (!isExpanded).toString())
      subMenu.classList.toggle('is-active')

      // Update button text for accessibility
      const span = button.querySelector('span')
      if (span) {
        span.textContent = isExpanded ? 'Open Sub Menu' : 'Close Sub Menu'
      }
    })
  })

  // Close menu when clicking outside
  document.addEventListener('click', (e: Event) => {
    const target = e.target as HTMLElement
    if (!mainNav.contains(target) && !menuToggle.contains(target)) {
      mainNav.classList.remove('is-active')
      menuToggle.setAttribute('aria-expanded', 'false')
      const span = menuToggle.querySelector('span')
      if (span) {
        span.textContent = 'Open Menu'
      }
    }
  })

  // Handle keyboard navigation
  mainNav.addEventListener('keydown', (e: Event) => {
    const keyboardEvent = e as KeyboardEvent
    const target = keyboardEvent.target as HTMLElement

    if (keyboardEvent.key === 'Escape') {
      const openSubMenus = mainNav.querySelectorAll('.sub-menu.is-active')
      if (openSubMenus.length) {
        e.preventDefault()
        openSubMenus.forEach((subMenu) => {
          subMenu.classList.remove('is-active')
          const toggle = (subMenu as HTMLElement).previousElementSibling
          if (toggle) {
            toggle.setAttribute('aria-expanded', 'false')
            const span = toggle.querySelector('span')
            if (span) {
              span.textContent = 'Open Sub Menu'
            }
          }
        })
      }
    }
  })
}
