# Full example

### 1. Installation

```sh
$ composer global require schickling/git-s3:dev-master
```

![](http://i.imgur.com/dWug1Fp.png)


### 2. Initialize
```sh
$ git-s3 config
```

![](http://i.imgur.com/bn6rDCF.png)


### 3. Do something...
Add something to your repository and commit your changes.
```sh
$ cd testRepo
$ touch newTestFile
$ git add .
$ git commit -m "Test file added"
$ cd ..
```

![](http://i.imgur.com/YQOfTGO.png)

### 4. Deploy
```sh
$ git-s3 deploy
```

![](http://i.imgur.com/b5FujiE.png)


That's it. Your data is now online.
