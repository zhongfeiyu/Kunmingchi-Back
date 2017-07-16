# 昆明池项目api文档  
> Author: zhongfeiyu@tiaozhan.com  
> Last update: 2017-7-16 信息部分API


## 错误信息  

#### 当请求出错时，api将以如下格式返回错误信息，请在Ajax请求中以(success == 0)判断请求是否成功。  
+ Response 200

        {
            success: 0,
			err_msg: '缺少必要参数'，
        }  


## 信息相关  

#### 按页获取新闻  `GET {base_url}/info/news`  
 
+ Request (application/json)

        {
			page： 1,
			page_size: 10,
			content: 1, //如果为0，返回值将不包含新闻的content
        }
+ Response 200

        {
            success: 1,
			page： 1,
			page_size: 10,
			page_num: 8,
			news:[{
				news_id: 1,
				title: '昆明池元宵灯会',
				time: '2017-7-16',
				content: '昆明池元宵灯会将于2018年...',
			},{
				news_id: 2,
				title: '天气预报',
				time: '2017-7-16',
				content: '下周本景点的天气预报是...',
			},
			//...
			],
        }  

#### 获取单条/多条新闻内容  `GET {base_url}/info/anews`  
 
+ Request (application/json)

        {
			news_id: [1, 2], 
        }
+ Response 200

        {
            success: 1,
			news:[{
				news_id: 1,
				title: '昆明池元宵灯会',
				time: '2017-7-16',
				content: '昆明池元宵灯会将于2018年...',
			},{
				news_id: 2,
				title: '天气预报',
				time: '2017-7-16',
				content: '下周本景点的天气预报是...',
			}],
        }  

#### 获取所有banner  `GET {base_url}/info/banners`  
 
+ Request (application/json)

        {
			// no param 
        }
+ Response 200

        {
            success: 1,
			banner_num: 3,
			banners:[{
				banner_id: 1,
				title: '昆明池元宵灯会',
				time: '2017-7-16',
				content: '昆明池元宵灯会将于2018年...',
				img_url: '/Uploads/img/123.png',
				jump_url: '',
			},{
				banner_id: 2,
				title: '天气预报',
				time: '2017-7-16',
				content: '下周本景点的天气预报是...',
				img_url: '/Uploads/img/124.png',
				jump_url: 'www.baidu.com',
			},{
				banner_id: 3,
				title: '天气预报',
				time: '2017-7-17',
				content: '下周本景点的天气预报是...',
				img_url: '/Uploads/img/125.png',
				jump_url: 'www.baidu.com',
			}],
        }  

