### INSTALLATION GUIDE:

1. Download the repository;

2. Copy video_helper.php to your ./application/helpers/ folder;

That's it, your good to go.

***

### USAGE:

**Load the Helper**

`$this->load->helper('video');`

***


**YOUTUBE**

With Youtube you can do 4 things:

    - Get the id from a given url;

    - Get all the embed code for one video;

    - Get thumbnails from Youtube about the video.

    - Get the url to the fullvideo in browser

**To get the ID you can just use this:**

    $youtube_url = 'http://www.youtube.com/watch?v=SLk4Ia0otko';

    $id = youtube_id($youtube_url);

Note that the url could have the http or not. Also if the id that is extracted from url is not a valid youtube video the method youtube_id will return false.

**To get thumbnails from a given youtube url or id**

This one accept two param:

      1 - Youtube URL or Youtube ID

      2 - The thumbnail (1 to 4)

     (being the 1º one the big thumbnail, the next 3 the one you see when hovering a small thumbnail on vimeo)

example:

      $youtube_url = 'http://www.youtube.com/watch?v=SLk4Ia0otko';

      $thumbs = youtube_thumbs($youtube_url);

This will return an array of thumbs, but if you use the second param like this:

`$thumbs = youtube_thumbs($youtube_url, 1);`

only the 1º thumb is returned.


**Get embed code for a given Youtube URL or ID**

For this one you can pass a lot of param.

      1 - Youtube URL or ID;

      2 - Width;

      3 - Height;

      4 - Old or new embed, TRUE/FALSE, default FALSE (new embed);

      5 - HD, TRUE/FALSE, default FALSE;

      6 - https, TRUE/FALSE, default FALSE;

      7 - Suggested videos, TRUE/FALSE, default FALSE;

**Example:**

`echo youtube_embed($youtube_url);`


**To get the fullvideo in browser link:**

You can use both a Youtube URL or a Youtube ID.

Example:

      $youtube_url = 'http://www.youtube.com/watch?v=SLk4Ia0otko';

      youtube_fullvideo($youtube_url);

***

**VIMEO**

With VImeo you can do 3 things:

    - Get the id from a given url;

    - Get all the embed code for one video;

    - Get thumbnails from Vimeo about the video.

**To get the ID you can just use this:**

    $vimeo_url = 'http://vimeo.com/26726530';

    $id = vimeo_id($vimeo_url);

Note that the url could have the http or not. In this case the video helper can't validate if the returned vimeo ID is a valid video, for that we'll need the vimeo API. And for now the video Helper doesn't use any API's.


**To get thumbnails from a given Vimeo url or id**

This one accept two param:

      1 - Vimeo URL or Vimeo ID

      2 - The thumbnail (1 to 3)

     (being the 1º one the small thumbnail, 2º is in medium size and the 3º in large size.)

     (The only thing that changes is the size.)

example:

      $vimeo_url = 'http://vimeo.com/26726530';

      $thumbs = vimeo_thumbs($vimeo_url);

This will return an array of thumbs, but if you use the second param like this:

`$thumbs = vimeo_thumbs($vimeo_url, 1);`

only the 1º thumb is returned.


**Get embed code for a given Vimeo URL or ID**

For this one you can pass a lot of param.

      1 - Vimeo URL or ID;

      2 - Width;

      3 - Height;

      4 - Color;

      5 - Autoplay, TRUE/FALSE, default FALSE;

**Example:**

`echo vimeo_embed($vimeo_url);`

### CHANGE LOG:

1.0.4

- Fix typo com Lupelius comments

- Remove extra spaces

1.0.3 (by Serdar Senay (Lupelius))

- Added vimeo_fullvideo method

- Fix applied where all methods had unnecessary if checks for checking valid ID, removed those as youtube|vimeo_id functions already check that

1.0.2

- Change structure to meet spark requirements

1.0.1

- Fix typo
- Fix problem with youtube embed

1.0.0

- Video Helper