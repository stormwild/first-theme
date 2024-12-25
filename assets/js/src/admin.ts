/**
 * Admin-specific JavaScript functionality
 */

document.addEventListener('DOMContentLoaded', () => {
  // Initialize admin-specific functionality
  initCustomizerPreview()
  initMediaUploads()
})

function initCustomizerPreview(): void {
  // Only run in customizer preview
  if (!window.wp?.customize) return

  // Update site title in real time
  window.wp.customize('blogname', (value) => {
    value.bind((newValue) => {
      const titleElement = document.querySelector('.site-title')
      if (titleElement) {
        titleElement.textContent = newValue
      }
    })
  })

  // Update site description in real time
  window.wp.customize('blogdescription', (value) => {
    value.bind((newValue) => {
      const descElement = document.querySelector('.site-description')
      if (descElement) {
        descElement.textContent = newValue
      }
    })
  })
}

function initMediaUploads(): void {
  // Only run in admin area
  if (!document.body.classList.contains('wp-admin')) return

  const mediaButtons = document.querySelectorAll('.upload-media-button')

  mediaButtons.forEach((button) => {
    button.addEventListener('click', (e: Event) => {
      e.preventDefault()

      // Check if wp.media is available
      if (!window.wp?.media) return

      const uploadButton = e.currentTarget as HTMLElement
      const inputField = document.querySelector(
        uploadButton.dataset.input || ''
      ) as HTMLInputElement

      if (!inputField) return

      // Create the media frame
      const frame = window.wp.media({
        title: 'Select or Upload Media',
        button: {
          text: 'Use this media',
        },
        multiple: false,
      })

      // When an image is selected in the media frame...
      frame.on('select', () => {
        const attachment = frame.state().get('selection').first().toJSON()
        inputField.value = attachment.url

        // If there's a preview image element, update it
        const previewImg = document.querySelector(
          uploadButton.dataset.preview || ''
        ) as HTMLImageElement

        if (previewImg && attachment.type === 'image') {
          previewImg.src = attachment.url
          previewImg.style.display = 'block'
        }
      })

      // Open the media frame
      frame.open()
    })
  })
}
