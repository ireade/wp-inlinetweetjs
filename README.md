# Wordpress InlineTweet.js

A wordpress plugin for [InlineTweet.js](https://github.com/ireade/inlinetweetjs)

![InlineTweet.js allows you to easily create tweetable links out of any text on a webpage. Just wrap the tweetable text in a container with data-inline-tweet and you're good to go!](https://github.com/ireade/inlinetweetjs/raw/gh-pages/screenshot.png)

- InlineTweet.js created by Ire Aderinokun ([Github](https://github.com/ireade) / [Twitter](https://twitter.com/ireaderinokun))
- Plugin created by Emma Kalson ([Github](https://github.com/creativecatapps) / [Twitter](https://twitter.com/CreativeCatApps))


## How to Use


#### 1 - Upload & Activate Plugin


[Dowmload this repository](https://github.com/ireade/wp-inlinetweetjs/archive/master.zip) and upload it to your wordpress site. Make sure to activate the plugin as well.



#### 2 - Global Settings

You can set some global settings for all Inline Tweets in your wordpress site. Do this by going to **Settings > Inline Tweets**. You can set the following global settings -

- Add a twitter username (without the @) to append to the tweet
- Add hashtags to the tweet (comma-separated, no spaces)
- Wrapper element for tweets (default is `<span>`)



#### 3 - Use Shortcode

You can now use the shortcode anywhere on your wordpress site. 

```
[inlinetweet]Click here to tweet this![/inlinetweet]
```



#### 3 - Local Settings

You can change any of the settings for the tweet locally -

You can add more data attributes to cutomise the tweeted output -

- `via` — Add a twitter username (without the @) to append to the tweet
- `tags` - Add hashtags to the tweet (comma-separated, no spaces)
- `url` — Tweet a URL different to the current page url
- `wrapper` - The element that wraps the tweet

```html
[inlinetweet via="creativecatapps" 
	     tags="webdesign,webdev,js,yolo" 
	     url="https://www.creativecatapps.co.uk/"
	     wrapper="p"]
	Lorem Khaled Ipsum is a major key to success 
[/inlinetweet]
```

