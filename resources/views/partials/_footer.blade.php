@inject('service', 'App\Services\ApiServiceCaller')

<footer class="footer">
    <div class="copyrights text-right">
        <p><a href="https://forum.gtanet.work/index.php?members/streetgt.81/">StreetGT &copy; 2016</a>  {{ formatVersion($service->getTotalCommits()) }}</p>
    </div>
</footer>