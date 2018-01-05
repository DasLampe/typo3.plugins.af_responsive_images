# Auto Responsive Images

## How to use
- Install Extension
- Check you have correct installed and configured imagemagick (or somthing similar) (Typo3 -> Install -> Test Setup)
- Use ViewHelper

### Example
```
{namespace dl = DasLampe\AfResponsiveImages\ViewHelper}
<dl:image image="{image}" srcSet="{700: 400, 200: 10}" />
```

Image must be TYPO3\CMS\Core\Resource\File-Object.

## Known Issues
Nothing yet. Feel free to report Issues!

## Contact
daslampe (at) lano-crew [dot] org
