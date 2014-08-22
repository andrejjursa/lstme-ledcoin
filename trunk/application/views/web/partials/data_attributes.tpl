{foreach $data as $data_attr => $data_value}
data-{$data_attr}="{$data_value|escape:'html'}"
{/foreach}