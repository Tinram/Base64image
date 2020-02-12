
# base64image


## Purpose

Output image files from base64-encoded image strings.

e.g. reconstruct images from base64 text which occurs as HTML `data:image` or in *.mht* files and emails.

Images can be output as JPEGs, GIFs, and PNGs.


## Usage

```bash
    php base64image.php examples/example.txt example.png
```

or if the script file is renamed, made executable, and present in *$PATH*:

```bash
    base64image examples/example.txt example.png
```


## License

base64image is released under the [GPL v.3](https://www.gnu.org/licenses/gpl-3.0.html).
