/**
 * Theme setup functionality
 */

interface ThemeSetupOptions {
  smoothScroll?: boolean
  lazyLoad?: boolean
  externalLinks?: boolean
}

export function setupTheme(options: ThemeSetupOptions = {}): void {
  const defaultOptions: ThemeSetupOptions = {
    smoothScroll: true,
    lazyLoad: true,
    externalLinks: true,
    ...options,
  }

  if (defaultOptions.smoothScroll) {
    enableSmoothScroll()
  }

  if (defaultOptions.lazyLoad) {
    setupLazyLoading()
  }

  if (defaultOptions.externalLinks) {
    handleExternalLinks()
  }

  // Initialize responsive tables
  setupResponsiveTables()

  // Initialize focus outline
  handleFocusOutline()
}

function enableSmoothScroll(): void {
  // Add smooth scrolling to all internal links
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener('click', (e: Event) => {
      e.preventDefault()
      const href = (e.currentTarget as HTMLAnchorElement).getAttribute('href')
      if (!href) return

      const target = document.querySelector(href)
      if (target) {
        target.scrollIntoView({
          behavior: 'smooth',
          block: 'start',
        })
        // Update URL without scrolling
        history.pushState(null, '', href)
      }
    })
  })
}

function setupLazyLoading(): void {
  // Use native lazy loading for images
  document.querySelectorAll('img[data-src]').forEach((img) => {
    const image = img as HTMLImageElement
    if ('loading' in HTMLImageElement.prototype) {
      image.loading = 'lazy'
      image.src = image.dataset.src || ''
    } else {
      // Fallback for browsers that don't support native lazy loading
      const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            const lazyImage = entry.target as HTMLImageElement
            lazyImage.src = lazyImage.dataset.src || ''
            observer.unobserve(lazyImage)
          }
        })
      })
      observer.observe(image)
    }
  })
}

function handleExternalLinks(): void {
  // Add appropriate attributes to external links
  document.querySelectorAll('a').forEach((link) => {
    if (
      link.hostname !== window.location.hostname &&
      !link.hasAttribute('rel')
    ) {
      link.setAttribute('rel', 'noopener noreferrer')
      link.setAttribute('target', '_blank')

      // Add visual indicator for screen readers
      if (!link.querySelector('.screen-reader-text')) {
        const srText = document.createElement('span')
        srText.className = 'screen-reader-text'
        srText.textContent = ' (Opens in a new window)'
        link.appendChild(srText)
      }
    }
  })
}

function setupResponsiveTables(): void {
  // Make tables responsive
  document.querySelectorAll('table').forEach((table) => {
    if (!table.parentElement?.classList.contains('table-wrapper')) {
      const wrapper = document.createElement('div')
      wrapper.className = 'table-wrapper'
      table.parentNode?.insertBefore(wrapper, table)
      wrapper.appendChild(table)
    }
  })
}

function handleFocusOutline(): void {
  // Show outline only when using keyboard navigation
  document.body.addEventListener('keydown', (e: KeyboardEvent) => {
    if (e.key === 'Tab') {
      document.body.classList.add('using-keyboard')
    }
  })

  document.body.addEventListener('mousedown', () => {
    document.body.classList.remove('using-keyboard')
  })
}
