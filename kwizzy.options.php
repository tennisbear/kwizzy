<?php
/**
 * Options file for Kwizzy
 *
 * @author Dennis Slade
 * @since  2012-07-29
 */


/**
 * MISCELLANEOUS SETTINGS
 */
$CSS_LOCATION          = '';			// leave empty if kwizzy.css file is in same directory as source files
$JS_LOCATION           = '';			// leave empty if kwizzy.js file is in same directory as source files

$FORM_ERROR_MESSAGE    = 'Please answer the questions highlighted in yellow, then click the Submit button again.';
$RESULTS_URI           = 'results.php';	// leave empty if results are shown on the same page
$SCORING               = AUTO_INCREASING;

/**
 * MAILING LIST SETTINGS
 */
$MAILING_LIST_ACCOUNT  = 'dennisslade';
$MAILING_LIST_USER     = '<insert encoded mailchimp id here>';
$MAILING_LIST_ID       = '9999999999';
$MAILING_LIST_URL      = "http://$MAILING_LIST_ACCOUNT.us2.list-manage.com/subscribe/post?u=$MAILING_LIST_USER&id=$MAILING_LIST_ID";


/**
 * THE QUESTIONS AND ANSWERS
 *
 * @todo Convert this hard-coded $KWIZZY_CONTENT array into reads from a PHP settings file
 * @todo Convert this hard-coded $KWIZZY_CONTENT array into reads from a database
 */
$KWIZZY_CONTENT = array
(
	array
	(
		QUESTION   => 'I am excited about my life and turned on by the things I get to do each day.',
		VALIDATION => REQUIRED,
		ANSWERS    => array
		              (
		                  'Never'
		                      => "You have been denying your deepest heart's desires. You may have told yourself that you are doing what you're doing for your family, or to make the money you need to do what you love some day, or for some higher purpose.<br><br>
In the meantime, you are miserable and just getting through each day. When someone asks you what you are passionate about, you probably feel numb, and can't even think of anything.<br><br>
You are at a critical turning point in your life. You need to take The Passion Test as soon as you can and begin making decisions based on what you care about.
 ",
		                  'Rarely'
		                      => "You've been denying your heart's desires. You have probably had good reasons: you are supporting your family, or raising your children, or making the money you think you need to do what you love some day.<br><br>
In the meantime, you're pretty miserable. Life is a drudgery. Every once in a while there is a little ray of light, but for the most part, life sucks.<br><br>
It's time for that to change. You took this profile because you know that. Start taking the steps that will help you become more connected to the things that matter most to you.
",
		                  'Sometimes'
		                      => "You are torn between the desire to follow your heart and your beliefs about what you think you HAVE to do. You may feel that you can't do what you love because you have responsibilities, or others who need your help, or because you need money. These are all beliefs that are keeping you separated from joy and fulfillment.<br><br>
When you do what is best for you, you are simultaneously doing what is best for others. When you clarify the things that mean most to you in your life, and then make your choices based on what will allow you to align your life with those things, then you will not only enjoy your life more yourself, but others will also enjoy being around you.<br><br>
You are at a turning point. This is your chance to permanently shift your life in the direction of joy and fulfillment. All it requires is making the commitment to change.
",
		                  'Most of the time'
		                      => "You have been waking up to the reality that only following your passions will bring you the fulfillment you deserve in your life. Now it's just a matter of having the courage to go full out.<br><br>
Notice when you are making choices that do not support our heart's desires, and be gentle with yourself. Living your passions is a process. It's enough to notice and as you do, each new decision will become more aligned with your true passions.<br><br>
You are well on your way. You may find The Passion Test process to be a valuable tool to help you take those final steps. It will help you identify those parts of your life that are very important, yet are still not 100% congruent.
Congratulations for coming this far.
",
		                  'All the time'
		                      => 'You have learned one of the most important lessons of life: When you choose in favor of your passions, life becomes an ongoing miracle. Congratulations for making decisions that allow you to give your special and unique gifts.<br><br>
Now you have the opportunity to look more deeply. The Passion Test is such a valuable tool because it allows anyone to see anywhere in their life that is not yet completely aligned with the things they love the most.<br><br>
Keep doing what you\'re doing and remember that what you put your attention on grows stronger in your life.
',
		              )
	),
	array
	(
		QUESTION   => 'Others comment on how happy I am and what fun it is to be around me.',
		VALIDATION => REQUIRED,
		ANSWERS    => array
		              (
		                  'Never'
		                      => 'You chose NEVER',
		                  'Rarely'
		                      => 'You chose RARELY',
		                  'Sometimes'
		                      => 'You chose SOMETIMES',
		                  'Frequently'
		                      => 'You chose FREQUENTLY',
		                  'All the time'
		                      => 'You chose ALL THE TIME',
		              )
	),
	array
	(
		QUESTION   => 'I get upset and thrown off track when unexpected situations and circumstances arise.',
		VALIDATION => REQUIRED,
		ANSWERS    => array
		              (
		                  'Never'
		                      => 'You chose NEVER',
		                  'Rarely'
		                      => 'You chose RARELY',
		                  'Sometimes'
		                      => 'You chose SOMETIMES',
		                  'Frequently'
		                      => 'You chose FREQUENTLY',
		                  'Always'
		                      => 'You chose ALL THE TIME',
		              )
	),
	array
	(
		QUESTION   => 'I am very clear about the top five passions in my life, those things that matter most to me.',
		VALIDATION => REQUIRED,
		ANSWERS    => array
		              (
		                  'Not at all'
		                      => 'You chose NEVER',
		                  'A little'
		                      => 'You chose RARELY',
		                  'Somewhat'
		                      => 'You chose SOMETIMES',
		                  'Quite clear'
		                      => 'You chose FREQUENTLY',
		                  'Crystal clear'
		                      => 'You chose ALL THE TIME',
		              )
	),
	array
	(
		QUESTION   => 'I make decisions based on what will help me live my passions most fully.',
		VALIDATION => REQUIRED,
		ANSWERS    => array
		              (
		                  'Never'
		                      => 'You chose NEVER',
		                  'Rarely'
		                      => 'You chose RARELY',
		                  'Sometimes'
		                      => 'You chose SOMETIMES',
		                  'Most of the time'
		                      => 'You chose FREQUENTLY',
		                  'All the time'
		                      => 'You chose ALL THE TIME',
		              )
	),
	array
	(
		QUESTION   => 'I spend my days doing things I love, surrounded by people I love.',
		VALIDATION => REQUIRED,
		ANSWERS    => array
		              (
		                  'Never'
		                      => 'You chose NEVER',
		                  'Rarely'
		                      => 'You chose RARELY',
		                  'Sometimes'
		                      => 'You chose SOMETIMES',
		                  'Most of the time'
		                      => 'You chose FREQUENTLY',
		                  'All the time'
		                      => 'You chose ALL THE TIME',
		              )
	),
	array
	(
		QUESTION   => 'Life is confusing for me. I don\'t have a clear sense of direction in my life',
		VALIDATION => REQUIRED,
		ANSWERS    => array
		              (
		                  'No sense of direction'
		                      => 'You chose NEVER',
		                  'Very little sense of direction'
		                      => 'You chose RARELY',
		                  'Some sense of direction'
		                      => 'You chose SOMETIMES',
		                  'Pretty clear sense of direction'
		                      => 'You chose FREQUENTLY',
		                  'Very clear sense of direction'
		                      => 'You chose ALWAYS',
		               )
	)
);


/**
 * THE INFO FORM
 *
 * @todo Convert this hard-coded $KWIZZY_INFO_FORM array into reads from a PHP settings file
 * @todo Convert this hard-coded $KWIZZY_INFO_FORM array into reads from a database
 */
$KWIZZY_INFO_FORM = array
(
	array
	(
		LABEL      => 'Your Name:',
		INPUT_TYPE => TEXT,
		VALIDATION => REQUIRED,
	),
	array
	(
		LABEL      => 'Your Email:',
		INPUT_TYPE => EMAIL,
		VALIDATION => REQUIRED,
	),
);


/* End of file kwizzy.options.php */
