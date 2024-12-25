declare namespace wp {
  interface CustomizeValue {
    bind: (callback: (newValue: string) => void) => void
  }

  interface CustomizePreview {
    bind: (setting: string, callback: (newValue: string) => void) => void
  }

  interface MediaFrame {
    on: (event: string, callback: () => void) => void
    open: () => void
    state: () => {
      get: (key: string) => {
        first: () => {
          toJSON: () => {
            url: string
            type: string
          }
        }
      }
    }
  }

  interface MediaOptions {
    title: string
    button: {
      text: string
    }
    multiple: boolean
  }

  interface Customize {
    (setting: string, callback: (value: CustomizeValue) => void): void
    preview?: CustomizePreview
  }

  interface Media {
    (options?: MediaOptions): MediaFrame
  }
}

interface Window {
  wp: {
    customize: wp.Customize
    media: wp.Media
  }
}
