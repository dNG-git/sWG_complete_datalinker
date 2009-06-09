<?xml version='1.0' encoding='UTF-8' ?>
<swg_datalinker_subs_list_v1 xmlns="urn:de.direct-netware.xmlns:swg.datalinker.subs.list.v1">
<phpexit><![CDATA[<?php exit (); ?>]]></phpexit>

<datalinker>
 <services sid='c0a38f7c90c17551fb03dbd2d80f0aba' name='account_pms'  />
 <services sid='87ecbe0ba0a0b3c7e60030043614e655' name='contentor' />
 <services sid='d4d66a02daefdb2f70ff2507a78fd5ec' name='datacenter' />
 <services sid='cb41ecf6e90a594dcea60b6140251d62' name='discuss' />
 <services sid='4ca5d171acaac2c5ca261c97b0d40383' name='vote' />

 <types>
  <default type='1' name='list' action='list' symbol='mini_datalinker_list.png' />
  <default type='2' name='object' action='view' symbol='mini_datalinker_object.png' />

  <c0a38f7c90c17551fb03dbd2d80f0aba type='1' name='inbox' action='box' symbol='mini_datalinker_list.png' />
  <c0a38f7c90c17551fb03dbd2d80f0aba type='2' name='outbox' action='box' symbol='mini_datalinker_list.png' />
  <c0a38f7c90c17551fb03dbd2d80f0aba type='3' name='custombox' action='box' symbol='mini_datalinker_list.png' />
  <c0a38f7c90c17551fb03dbd2d80f0aba type='4' name='inmessage' action='message' symbol='mini_datalinker_object.png' />
  <c0a38f7c90c17551fb03dbd2d80f0aba type='5' name='outmessage' action='message' symbol='mini_datalinker_object.png' />

  <digitstart__87ecbe0ba0a0b3c7e60030043614e655 type='1' name='cat' action='cat' symbol='mini_contentor_cat.png' />
  <digitstart__87ecbe0ba0a0b3c7e60030043614e655 type='2' name='doc' action='doc' symbol='mini_contentor_doc.png' />

  <d4d66a02daefdb2f70ff2507a78fd5ec type='1' name='directory' action='directory' symbol='mini_datacenter_directory.png' />
  <d4d66a02daefdb2f70ff2507a78fd5ec type='2' name='file' action='file' symbol='mini_datacenter_file.png' />
  <d4d66a02daefdb2f70ff2507a78fd5ec type='3' name='link' action='link' symbol='mini_datacenter_link.png' />

  <cb41ecf6e90a594dcea60b6140251d62 type='1' name='zone' action='board' symbol='mini_discuss_zone.png' />
  <cb41ecf6e90a594dcea60b6140251d62 type='2' name='forumzone' action='board' symbol='mini_discuss_forumzone.png' />
  <cb41ecf6e90a594dcea60b6140251d62 type='3' name='forum' action='board' symbol='mini_discuss_forum.png' />
  <cb41ecf6e90a594dcea60b6140251d62 type='4' name='link' action='link' symbol='mini_discuss_link.png' />
  <cb41ecf6e90a594dcea60b6140251d62 type='5' name='topic' action='topic' symbol='mini_discuss_topic.png' />
  <cb41ecf6e90a594dcea60b6140251d62 type='6' name='post' action='post' symbol='mini_discuss_post.png' />

  <digitstart__4ca5d171acaac2c5ca261c97b0d40383 type='1' name='vote' action='vote' symbol='mini_vote.png' />
  <digitstart__4ca5d171acaac2c5ca261c97b0d40383 type='2' name='vote_option' action='vote_option' symbol='mini_datalinker_object.png' />
 </types>
</datalinker>
</swg_datalinker_subs_list_v1>